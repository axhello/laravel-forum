<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Discussion;
use App\Favorite;
use App\Http\Controllers\Controller;
use App\Like;
use App\User;
use App\Tag;
use App\Markdown\Markdown;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    protected $markdown;

    /**
     * PostController constructor.
     */
    public function __construct(Markdown $markdown)
    {
        $this->middleware('users', ['except' => ['index', 'show']]);
        $this->markdown = $markdown;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discussions = Discussion::latest()->paginate(20);
        return view('forum.index', compact('discussions'));
//        return $this->city->city();
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::lists('name', 'id');
        return view('forum.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreatePostRequest $request)
    {
        $data = ['user_id' => \Auth::user()->id, 'last_user_id' => \Auth::user()->id];
        $discussion = Discussion::create(array_merge($request->all(), $data));
        $tag_lists = $request->get('tag_list');
        $tag_list = empty($tag_lists) ? array() : $tag_lists;
        if ($discussion) {
            $this->attachTags($discussion, $tag_list);
            return redirect()->action('PostController@show', [$discussion->id]);
        } else {
            return redirect()->back()->withInput()->withErrors('body', '保存失败！');
        }
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $discussion = Discussion::findOrFail($id);
        if (\Auth::check()) {
            $favorites = Favorite::where('user_id', \Auth::user()->id)->lists('discussion_id')->toArray();
        }
        $comments = $discussion->comments()->paginate(10);
        $html = $this->markdown->markdown($discussion->body);

//        if (\Auth::check()) {
        $like1= Like::lists('name')->toArray();
        $like2= Like::lists('comment_id')->toArray();
        $like3= Like::lists('name','comment_id')->toArray();
        $arr = array_merge($like1,$like2);
        return view('forum.show', compact('discussion', 'favorites', 'comments', 'html', 'likes'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $discussion = Discussion::findOrFail($id);
        $tags = Tag::lists('name', 'id');
        if (\Auth::user()->id !== $discussion->user_id) {
            redirect('/');
        }
        return view('forum.edit', compact('discussion', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\CreatePostRequest $request, $id)
    {
        $discussion = Discussion::findOrFail($id);
        $discussion->update($request->all());
        $tag_lists = $request->get('tag_list');
        $tag_list = empty($tag_lists) ? array() : $tag_lists;
        if ($discussion->save()) {
            $this->syncTags($discussion, $tag_list);
            return redirect()->action('PostController@show', [$discussion->id]);
        } else {
            return redirect()->back()->withInput()->withErrors('body', '保存失败');
        }
    }

    /**
     * Upload the File
     * @return string
     */
    public function upload()
    {
        $data = \EndaEditor::uploadImgFile('uploads');
        return json_encode($data);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     *  Attach tag relation adding new tags as needed
     * @param array $tags
     */
    public function attachTags(Discussion $discussion, array $tags)
    {
        foreach ($tags as $key => $tag) {
            if (!is_numeric($tag)) {
                $newTag = Tag::create(['name' => $tag]);
                $tags[$key] = $newTag->id;
            }
        }
        $discussion->tags()->attach($tags);
    }

    /**
     * Sync tag relation adding new tags as needed
     * @param array $tags
     */
    public function syncTags(Discussion $discussion, array $tags)
    {
        foreach ($tags as $key => $tag) {
            if (!is_numeric($tag)) {
                $newTag = Tag::create(['name' => $tag]);
                $tags[$key] = $newTag->id;
            }
        }
        $discussion->tags()->sync($tags);
    }
}
