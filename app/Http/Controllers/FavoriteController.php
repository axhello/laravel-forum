<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class FavoriteController extends Controller
{
    /**
     * FavoriteController constructor.
     */
    public function __construct()
    {
//        $this->middleware('users');
    }
    public function store(Request $request)
    {
        \Auth::user()->favorites()->attach($request->get('discussion_id'));

        return redirect()->back();
    }

    public function destroy($id)
    {
        \Auth::user()->favorites()->detach($id);
        return redirect()->back();
    }

    public function favorites()
    {
        $user = User::findOrFail(\Auth::user()->id);
        $favorites = $user->favorites()->paginate(15);
//        dd($favorites);
        return view('users.favorites',compact('user','favorites'));
    }

    public function check()
    {

    }
}
