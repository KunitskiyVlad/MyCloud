<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
class ControllerFile extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(File $FileClass)
    {
        //
        $files = File::whereDate('created_at', Carbon::today())->orderBy('count_download', 'DESC')->take(100)->get();
        $i=0;
        foreach ($files as $file){
            $files[$i]['size_file'] = $FileClass->getSize($file['size_file']);
            $i++;
            $UserUpload[$file['user_id']] = File::find($file['id'])->uploadBy;
        }
        return view('ShowFiles.ShowFile',[
            'files'=>$files,
            'UserUpload'=>$UserUpload,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('UploadFile.UploadPage');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, File $uploadFile)
    {
        $uploadBy=null;
        if (Auth::check()) {
            $uploadBy = Auth::user()->id;
        }
        $uploadFile->upload($request->file(),$uploadBy);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function download(Request $request, File $uploadFile)
    {
        //dd($request->all());
        $dataFile = $request->input('FileName');//->except(['_method', '_token']);
        return $uploadFile->download($dataFile);
    }
}
