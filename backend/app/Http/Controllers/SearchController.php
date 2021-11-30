<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Vender\CallTwitterApi;

class SearchController extends Controller
{
    public function search(Request $request) {
        $request->session()->forget([
            'outputs', 'NumberOfTweets', 'negaPosi', 
            'tweetIds', 'positiveTweetIds', 'neutralTweetIds',
            'negativeTweetIds','wordRank'
        ]);
        return view('search');
    }
}