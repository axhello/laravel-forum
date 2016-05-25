<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Response;

class FavoriteController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        \Auth::user()->favorites()->attach($request->get('discussion_id'));

        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        \Auth::user()->favorites()->detach($id);
        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function favorites()
    {
        $user = User::findOrFail(\Auth::user()->id);
        $favorites = $user->favorites()->paginate(15);
        return view('users.favorites',compact('user','favorites'));
    }

}
