<?php

namespace App\Http\Controllers;

use App\Discussion;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $keywords = $request->input('query');
        $results = Discussion::where('title','like','%'.$keywords.'%')
                            ->orWhere('body','like','%'.$keywords.'%')
                            ->paginate(10);
//        $results = \DB::table('discussions')->where('title','like','%'.$keywords.'%')->get();
        return view('forum.search', compact('results'));
    }
}
