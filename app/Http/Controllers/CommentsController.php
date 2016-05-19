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
        $html = $this->markdown->markdown($content);
        Comment::create([
            'discussion_id' => $request->get('discussion_id'),
            'body'=> $html,
            'user_id' => \Auth::user()->id
        ]);
        return response()->json([ 'html' => $html ]);
    }

    public function upload(Request $request)
    {
        $disk = QiniuStorage::disk('qiniu');
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->getPathname();
        $disk->uploadToken($fileName);
        $result = $disk->putFile($fileName, $filePath);
        $imgUrl = $disk->downloadUrl($result['key']);
        return response()->json([
            'status' => 'success',
            'url' => $imgUrl
        ]);
    }
}
