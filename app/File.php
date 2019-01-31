<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //
    private $dir ='Cloud/';
    protected $fillable = ['old_name', 'new_name', 'user_id', 'original_type_mime', 'count_download', 'size_file', 'type'],
              $table = 'upload_files';
    public function getSize($size)
    {
        if($size<1000){
            return $size.' '.__('interface.byte');
        }
        $new_size = $size/1000;

        If($new_size > 1000)
        {
            $new_size = $new_size/1000;
            if($new_size > 1000)
            {
               return false;
            }
            else
            {
                return $new_size.' '.__('interface.mb');
            }
        }
        else
            return $new_size.' '.__('interface.kb');
    }

    public function getType($TypeMime)
    {
        $pos = stripos($TypeMime, '/');
        $Type = substr($TypeMime, 0, $pos);
        return $Type;
    }

    public function upload($files, $uploadBy=null){
        if(isset($avatars))
            $dopPath = $avatars;
        else
        {
            $dopPath ='';
        }
        $DataFile['upload_by'] = $uploadBy;
        foreach ($files as $file) {
            $directory = $this->dir . $dopPath;
            $DataFile['original_name'] = $file->getClientOriginalName();
            $DataFile['size'] = $file->getClientSize();

            $DataFile['original_mime_type'] = $file->getClientMimeType();
            $DataFile['type'] = $this->getType($DataFile['original_mime_type']);

            $bytes = random_bytes(5);
            $DataFile['new_name'] = bin2hex($bytes);
            $path = 'public/'.$this->dir;
            $DataFile['new_name'] = $directory . $DataFile['new_name'] . '.txt';



            if ($file->storeAs($path, $DataFile['new_name'])) {
                File::create([
                    'old_name' => $DataFile['original_name'],
                    'new_name' => $DataFile['new_name'],
                    'user_id' => $DataFile['upload_by'],
                    'original_type_mime' => $DataFile['original_mime_type'],
                    'size_file' => $DataFile['size'],
                    'type' => $DataFile['type']
                ]);

            } else
                return false;
        }
    }
    public function download($data)
    {

        $file = File::where('new_name', '=', $data)->get();
        File::where('new_name', '=', $data)->increment('count_download');
        foreach ($file as $temp)
        {
            $dataFile['old_name'] = $temp['old_name'];
            $dataFile['new_name'] = $temp['new_name'];
            $dataFile['content-type'] = $temp['original_type_mime'];

        }
        return response()->json(['href' =>'/storage/'.$this->dir.$dataFile['new_name'],'oldName'=>$dataFile['old_name'],'contentType'=>$dataFile['content-type']]);
    }

    public function uploadBy(){
        return $this->belongsTo('App\User','user_id');
    }

    public function comment(){
        return $this->hasMany('App\Comment');
    }

    public function createAvatar($text){
        $image = imagecreate(50,50);
        $background_color = imagecolorallocate($image, 0, 85, 255);
        $text_color = imagecolorallocate($image, 255, 255, 255);
        $font = public_path('Fonts.ttf');
        imagettftext($image, 27, 0, 15,38, $text_color,$font,$text);
        $file_name=bin2hex(random_bytes(5)).'.png';
        imagepng($image,storage_path('app/public/Avatars/'.$file_name));
        imagedestroy($image);
        return $file_name;
    }

    public function saveUserAvatar($content){
        $file_name = bin2hex(random_bytes(5)).'.png';
        $stringBase64 = base64_decode(substr_replace($content,'',0,strripos($content,',')+1));
        file_put_contents(storage_path('app/public/Avatars/').$file_name,$stringBase64);
        return $file_name;
    }

}
