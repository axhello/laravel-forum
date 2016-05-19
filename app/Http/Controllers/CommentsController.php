<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Markdown\Markdown;
use Illuminate\Http\Request;
use itbdw\QiniuStorage\QiniuStorage;

class CommentsController extends Controller
{
    protected $markdown;

    /**
     * CommentsController constructor.
     * @param $markdown
     */
    public function __construct(Markdown $markdown)
    {
        $this->markdown = $markdown;
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), ['body' => 'required']);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $content = $request->get('body');
        //然后markdown处理
        $html = $this->markdown->markdown($content);
        Comment::create(['discussion_id' => $request->route('id'), 'body'=> $html, 'user_id' => \Auth::user()->id]);
        // return redirect()->action('PostController@show', ['id' => $request->get('discussion_id')]);
        return response()->json(['html'=>$html]);
    }

    public function upload(Request $request)
    {
        if ($file = $request->file('file')) {
            $allowed_extensions = ["png", "jpg", "gif"];
            if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
                return ['error' => 'You may only upload png, jpg or gif.'];
            }
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $folderName      = '/uploads/' . date("Ym", time()) . date("d", time());
            $destinationPath = public_path() . '/' . $folderName;
            $safeName        = str_random(10).'.'.$extension;

            $disk = QiniuStorage::disk('qiniu');
            $disk->exists($destinationPath);                      //文件是否存在
            $files = $disk->get($destinationPath);
            dd($files);
        }
    }
}
