<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = \Auth::user();
        $data = [
            'name' => $request->get('name'),
            'user_id' => \Auth::user()->id,
            'comment_id' => $request->get('comment_id')
        ];
//        dd($data);
        Like::create($data);
//        \Auth::user()->likes()->create($data);
//        $user->likes()->attach($data);


        return response()->json([
            'code'=> '200'
        ]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $user_id = \Auth::user()->id;
        Like::where('user_id', '=', $user_id)->delete();

        return response()->json([
            'code'=> '200'
        ]);
    }
}
