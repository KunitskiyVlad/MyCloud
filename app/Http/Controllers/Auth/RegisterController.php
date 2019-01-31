<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request,File $file)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all(), $file)));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        Validator::extend('is_png', function ($attribute, $value, $parameters) {
            $info_pipe = finfo_open();
            $stringBase64 = substr_replace($value,'',0,strripos($value,',')+1);
            $myme_type = finfo_buffer($info_pipe, base64_decode($stringBase64),FILEINFO_MIME_TYPE);
            $stringCheck =substr($myme_type, strpos($myme_type,'/')+1,3);
            if($stringCheck ==='png'){
                return true;
            }
            else{
                return false;
            }
        });

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'avatar'=>'nullable|is_png'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data,File $file)
    {
        if($data['avatar'] ===null){
            $FirstLeter = substr($data['name'],0,1);
            $data['avatar'] = $file->createAvatar($FirstLeter);
        } else{
            $data['avatar'] = $file->saveUserAvatar($data['avatar']);
        }
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'avatar'=>$data['avatar'],
        ]);
    }
    public function checkUniqueEmail(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }
        return response()->json(['success'=>true]);
    }
}
