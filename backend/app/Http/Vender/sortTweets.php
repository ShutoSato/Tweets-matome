<?php

namespace App\Http\Vender;

use Illuminate\Http\Request;
use App\Http\Vender\CallTwitterApi;

class sortTweets
{
    public function sortAllTweet(Request $request){
        // sessionからツイート数を取得
        $NumberOfTweets = $request->session()->get('NumberOfTweets');
        // sessionからtweetsDataを取得
        $tweetsData = $request->session()->get('tweetsData');
        // twitterApi呼び出し
        $twitterApi = new CallTwitterApi();
        // ソート, $tweetsDataの書き換えがしたい
        $sort = $request->sort;
        if($sort=='time'){
            $tweetsData = $request->session()->get('defaultTweetsData');
        }elseif($sort=='RT_count'){ // RTでソート
            for( $i=0; $i<$NumberOfTweets; $i++){
                // tweetIdを取得
                $tweetId = $tweetsData[$i]['tweetId'];
                // RT数を取得
                $tweetsData[$i]['RT_count'] = $twitterApi->statusesShowRT($tweetId);
            }
            // 配列→コレクションに変更
            $tweetsData = collect($tweetsData);
            // ソート実行
            $tweetsData = $tweetsData->sortByDesc('RT_count')->values()->toArray();
        }elseif($sort=='fav_count'){ // いいね数でソート
            for( $i=0; $i<$NumberOfTweets; $i++){
                // tweetIdを取得
                $tweetId = $tweetsData[$i]['tweetId'];
                // いいね数を取得
                $tweetsData[$i]['fav_count'] = $twitterApi->statusesShowFav($tweetId);
            }
            // 配列→コレクションに変更
            $tweetsData = collect($tweetsData);
            // ソート実行
            $tweetsData = $tweetsData->sortByDesc('fav_count')->values()->toArray();
        }
        // ソート後の$tweetsDataをsessionに保存
        $request->session()->put('tweetsData', $tweetsData);
    }

    public function sortPositiveTweets(Request $request){
        // sessionからpositiveTweetsDataを取得
        $positiveTweetsData = $request->session()->get('positiveTweetsData');
        // positiveTweetの数を取得
        $NumberOfPositiveTweets = count($positiveTweetsData);
        // twitterApi呼び出し
        $twitterApi = new CallTwitterApi();
        // ソート, $positiveTweetsDataの書き換えがしたい
        $sort = $request->sort;
        if($sort=='time'){
            $positiveTweetsData = $request->session()->get('defaultPositiveTweetsData');
        }elseif($sort=='RT_count'){ // RTでソート
            for( $i=0; $i<$NumberOfPositiveTweets; $i++){
                // tweetIdを取得
                $tweetId = $positiveTweetsData[$i]['tweetId'];
                // RT数を取得
                $positiveTweetsData[$i]['RT_count'] = $twitterApi->statusesShowRT($tweetId);
            }
            // 配列→コレクションに変更
            $positiveTweetsData = collect($positiveTweetsData);
            // ソート実行
            $positiveTweetsData = $positiveTweetsData->sortByDesc('RT_count')->values()->toArray();
        }elseif($sort=='fav_count'){ // いいね数でソート
            for( $i=0; $i<$NumberOfPositiveTweets; $i++){
                // tweetIdを取得
                $tweetId = $positiveTweetsData[$i]['tweetId'];
                // いいね数を取得
                $positiveTweetsData[$i]['fav_count'] = $twitterApi->statusesShowFav($tweetId);
            }
            // 配列→コレクションに変更
            $positiveTweetsData = collect($positiveTweetsData);
            // ソート実行
            $positiveTweetsData = $positiveTweetsData->sortByDesc('fav_count')->values()->toArray();
        }
        // ソート後の$tweetsDataをsessionに保存
        $request->session()->put('positiveTweetsData', $positiveTweetsData);
    }

    public function sortNeutralTweets(Request $request){
        // sessionからneutralTweetsDataを取得
        $neutralTweetsData = $request->session()->get('neutralTweetsData');
        // neutralTweetの数を取得
        $NumberOfNeutralTweets = count($neutralTweetsData);
        // twitterApi呼び出し
        $twitterApi = new CallTwitterApi();
        // ソート, $neutralTweetsDataの書き換えがしたい
        $sort = $request->sort;
        if($sort=='time'){
            $neutralTweetsData = $request->session()->get('defaultNeutralTweetsData');
        }elseif($sort=='RT_count'){ // RTでソート
            for( $i=0; $i<$NumberOfNeutralTweets; $i++){
                // tweetIdを取得
                $tweetId = $neutralTweetsData[$i]['tweetId'];
                // RT数を取得
                $neutralTweetsData[$i]['RT_count'] = $twitterApi->statusesShowRT($tweetId);
            }
            // 配列→コレクションに変更
            $neutralTweetsData = collect($neutralTweetsData);
            // ソート実行
            $neutralTweetsData = $neutralTweetsData->sortByDesc('RT_count')->values()->toArray();
        }elseif($sort=='fav_count'){ // いいね数でソート
            for( $i=0; $i<$NumberOfNeutralTweets; $i++){
                // tweetIdを取得
                $tweetId = $neutralTweetsData[$i]['tweetId'];
                // いいね数を取得
                $neutralTweetsData[$i]['fav_count'] = $twitterApi->statusesShowFav($tweetId);
            }
            // 配列→コレクションに変更
            $neutralTweetsData = collect($neutralTweetsData);
            // ソート実行
            $neutralTweetsData = $neutralTweetsData->sortByDesc('fav_count')->values()->toArray();
        }
        // ソート後の$tweetsDataをsessionに保存
        $request->session()->put('neutralTweetsData', $neutralTweetsData);
    }

    public function sortNegativeTweets(Request $request){
        // sessionからnegativeTweetsDataを取得
        $negativeTweetsData = $request->session()->get('negativeTweetsData');
        // negativeTweetの数を取得
        $NumberOfNegativeTweets = count($negativeTweetsData);
        // twitterApi呼び出し
        $twitterApi = new CallTwitterApi();
        // ソート, $negativeTweetsDataの書き換えがしたい
        $sort = $request->sort;
        if($sort=='time'){
            $negativeTweetsData = $request->session()->get('defaultNegativeTweetsData');
        }elseif($sort=='RT_count'){ // RTでソート
            for( $i=0; $i<$NumberOfNegativeTweets; $i++){
                // tweetIdを取得
                $tweetId = $negativeTweetsData[$i]['tweetId'];
                // RT数を取得
                $negativeTweetsData[$i]['RT_count'] = $twitterApi->statusesShowRT($tweetId);
            }
            // 配列→コレクションに変更
            $negativeTweetsData = collect($negativeTweetsData);
            // ソート実行
            $negativeTweetsData = $negativeTweetsData->sortByDesc('RT_count')->values()->toArray();
        }elseif($sort=='fav_count'){ // いいね数でソート
            for( $i=0; $i<$NumberOfNegativeTweets; $i++){
                // tweetIdを取得
                $tweetId = $negativeTweetsData[$i]['tweetId'];
                // いいね数を取得
                $negativeTweetsData[$i]['fav_count'] = $twitterApi->statusesShowFav($tweetId);
            }
            // 配列→コレクションに変更
            $negativeTweetsData = collect($negativeTweetsData);
            // ソート実行
            $negativeTweetsData = $negativeTweetsData->sortByDesc('fav_count')->values()->toArray();
        }
        // ソート後の$tweetsDataをsessionに保存
        $request->session()->put('negativeTweetsData', $negativeTweetsData);
    }
}