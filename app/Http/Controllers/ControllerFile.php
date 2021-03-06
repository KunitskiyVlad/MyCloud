<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use App\Comment;
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

        $UserUpload =null;
        $comments = null;
        $authorComment= null;
        $files = File::whereDate('created_at', Carbon::today())->orderBy('count_download', 'DESC')->take(100)->get();
        $i=0;

        foreach ($files as $file){
            $files[$i]['size_file'] = $FileClass->getSize($file['size_file']);
            $i++;
            $UserUpload[$file['user_id']] = File::find($file['id'])->uploadBy;
            $temp = File::find($file['id'])->comment;
            if(!$temp->isEmpty()){
                foreach ($temp as $comment)
                $authorComment[$comment['id']] = Comment::find($comment['id'])->user;
            }
            $comments[$file['id']] =$temp->groupBy('parent_id');
        }
        return view('ShowFiles.ShowFile',[
            'files'=>$files,
            'UserUpload'=>$UserUpload,
            'comments'=>$comments,
            'authorComment'=>$authorComment,
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
        if($uploadFile->upload($request->file(),$uploadBy)){
            return response()->json(['success'=>true,'successUpload'=>__('interface.successLoad')]);
        }
        else{
            return response()->json(['success'=>false,'error'=>__('interface.failedUpload')]);
        }

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

        $dataFile = $request->input('FileName');
        return $uploadFile->download($dataFile);
    }

    public function search(Request $request,File $FileClass){
        $UserUpload =null;
        $comments = null;
        $authorComment= null;
        $files = $FileClass->search($request->input('q'))->get();
        $i=0;
        $FileClass->createAvatar('B');
        foreach ($files as $file){
            $files[$i]['size_file'] = $FileClass->getSize($file['size_file']);
            $i++;
            $UserUpload[$file['user_id']] = File::find($file['id'])->uploadBy;
            $temp = File::find($file['id'])->comment;
            if(!$temp->isEmpty()){
                foreach ($temp as $comment)
                    $authorComment[$comment['id']] = Comment::find($comment['id'])->user;
            }
            $comments[$file['id']] =$temp->groupBy('parent_id');
        }
        return view('ShowFiles.SearchFile',['files'=>$files,
            'UserUpload'=>$UserUpload,
            'comments'=>$comments,
            'authorComment'=>$authorComment,]);
    }
}
