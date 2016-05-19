<?php

namespace App\Http\Controllers;

use App\Discussion;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $keywords = $request->input('query');
        $results = Discussion::where('title','like','%'.$keywords.'%')
                            ->orWhere('body','like','%'.$keywords.'%')
                            ->paginate(10);
        return view('forum.search', compact('results'));
    }
}
