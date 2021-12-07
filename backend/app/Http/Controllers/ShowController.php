<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Vender\CallTwitterApi;
use App\Http\Vender\sortTweets;

class ShowController extends Controller
{
    // 結果表示
    public function showResult($searchWord, Request $request){
        // sessionから値を取得
        $NumberOfTweets = $request->session()->get('NumberOfTweets');
        $negaPosi = $request->session()->get('negaPosi');
        $wordRank = $request->session()->get('wordRank');
        // resultページ表示
        return view('result', [
            'searchWord' => $searchWord,
            'NumberOfTweets' => $NumberOfTweets,
            'negaPosi' => $negaPosi,
            'wordRank' => $wordRank,
        ]);
    }

    // paginateで1ページに表示するツイートの数
    public $disp_limit_tweets = 5;

    // ツイート表示
    public function showAllTweets($searchWord, Request $request){
        // ソート
        $sort = $request->sort;
        if($sort!=null){
            $sortTweets = new sortTweets();
            $sortTweets->sortAllTweet($request);
        }
        // 現在ページの取得
        $page = $request->page;
        // ネガポジ判定内容詳細の表示
        $show = $request->show;
        // sessionからtweetsDataを取得
        $tweetsData = $request->session()->get('tweetsData');
        // Tweetのhtml形式を取得
        foreach($tweetsData as $tweetData){
            $tweets[] = [
                'tweetHtml' => $tweetData['tweetHtml'],
                'negaPosiValue' => $tweetData['negaPosiValue'],
                'negaPosiDetail' => $tweetData['negaPosiDetail']
            ];
        }
        // 配列→コレクションに変更, 変数名を$tweetsHtmlから$tweetsとする
        $tweets = collect($tweets);
        // paginate処理
        $tweets = new LengthAwarePaginator(
            $tweets -> forPage($request->page, $this->disp_limit_tweets), 
            count($tweets), 
            $this->disp_limit_tweets, 
            $request->page, 
            array('path' => $request->url())
        );
        // 全てのツイートを表示
        return view('showTweets',[
            'page' => $page,
            'tweets' => $tweets,
            'status' => null,
            'show' => $show,
            'searchWord' => $searchWord,
        ]);
    }

    // ポジティブツイートの表示
    public function showPositiveTweets($searchWord, Request $request){
        // ソート
        $sort = $request->sort;
        if($sort!=null){
            $sortTweets = new sortTweets();
            $sortTweets->sortPositiveTweets($request);
        }
        // 現在ページの取得
        $page = $request->page;
        // ネガポジ判定内容の詳細表示
        $show = $request->show;
        // sessionからpositiveTweetsDataを取得
        $positiveTweetsData = $request->session()->get('positiveTweetsData');
        // もし$positiveTweetがなかったら
        if($positiveTweetsData == null){
            // nullを格納
            $positiveTweets = null;
        }else{ // $positiveTweetがある場合
            // Tweetのhtml形式, ネガポジ判定内容を取得
            foreach($positiveTweetsData as $positiveTweetData){
                $positiveTweets[] = [
                    'tweetHtml' => $positiveTweetData['tweetHtml'],
                    'negaPosiValue' => $positiveTweetData['negaPosiValue'],
                    'contentsOfNegaPosiJudge' => $positiveTweetData['contentsOfNegaPosiJudge']
                ];
            }
            // 配列→コレクションに変更
            $positiveTweets = collect($positiveTweets);
            // paginate処理
            $positiveTweets = new LengthAwarePaginator(
                $positiveTweets -> forPage($request->page, $this->disp_limit_tweets), 
                count($positiveTweets), 
                $this->disp_limit_tweets, 
                $request->page, 
                array('path' => $request->url())
            );
        }
        // ポジティブツイートを表示
        return view('showTweets',[
            'page' => $page,
            'tweets' => $positiveTweets,
            'status' => 'Positive',
            'show' => $show,
            'searchWord' => $searchWord,
        ]);
    }

    // ニュートラルツイートの表示
    public function showNeutralTweets($searchWord, Request $request){
        // ソート
        $sort = $request->sort;
        if($sort!=null){
            $sortTweets = new sortTweets();
            $sortTweets->sortNeutralTweets($request);
        }
        // 現在ページの取得
        $page = $request->page;
        // ネガポジ判定内容の詳細表示
        $show = $request->show;
        // sessionからneutralTweetsDataを取得
        $neutralTweetsData = $request->session()->get('neutralTweetsData');
        // もしneutralTweetがなかったら
        if($neutralTweetsData == null){
            // nullを格納
            $neutralTweets = null;
        }else{ // neutralTweetがある場合
            // Tweetのhtml形式, ネガポジ判定内容を取得
            foreach($neutralTweetsData as $neutralTweetData){
                $neutralTweets[] = [
                    'tweetHtml' => $neutralTweetData['tweetHtml'],
                    'negaPosiValue' => $neutralTweetData['negaPosiValue'],
                    'contentsOfNegaPosiJudge' => $neutralTweetData['contentsOfNegaPosiJudge']
                ];
            }
            // 配列→コレクションに変更
            $neutralTweets = collect($neutralTweets);
            // paginate処理
            $neutralTweets = new LengthAwarePaginator(
                $neutralTweets -> forPage($request->page, $this->disp_limit_tweets), 
                count($neutralTweets), 
                $this->disp_limit_tweets, 
                $request->page, 
                array('path' => $request->url())
            );
        }
        // ニュートラルツイートを表示
        return view('showTweets',[
            'page' => $page,
            'tweets' => $neutralTweets,
            'status' => 'Neutral',
            'show' => $show,
            'searchWord' => $searchWord,
        ]);
    }

    // ネガティブツイートの表示
    public function showNegativeTweets($searchWord, Request $request){
        // ソート
        $sort = $request->sort;
        if($sort!=null){
            $sortTweets = new sortTweets();
            $sortTweets->sortNegativeTweets($request);
        }
        // 現在ページの取得
        $page = $request->page;
        // ネガポジ判定内容の詳細表示
        $show = $request->show;
        // sessionからnegativeTweetsDataを取得
        $negativeTweetsData = $request->session()->get('negativeTweetsData');
        // もし$negativeTweetがなかったら
        if($negativeTweetsData == null){
            // nullを格納
            $negativeTweets = null;
        }else{ // $negativeTweetがある場合
            // Tweetのhtml形式, ネガポジ判定内容を取得
            foreach($negativeTweetsData as $negativeTweetData){
                 $negativeTweets[] = [
                    'tweetHtml' => $negativeTweetData['tweetHtml'],
                    'negaPosiValue' => $negativeTweetData['negaPosiValue'],
                    'contentsOfNegaPosiJudge' => $negativeTweetData['contentsOfNegaPosiJudge']
                 ];
            }
            // 配列→コレクションに変更
            $negativeTweets = collect($negativeTweets);
            // paginate処理
            $negativeTweets = new LengthAwarePaginator(
                $negativeTweets -> forPage($request->page, $this->disp_limit_tweets), 
                count($negativeTweets), 
                $this->disp_limit_tweets, 
                $request->page, 
                array('path' => $request->url())
            );
        }
        // ネガティブツイートを表示
        return view('showTweets',[
            'page' => $page,
            'tweets' => $negativeTweets,
            'status' => 'Negative',
            'show' => $show,
            'searchWord' => $searchWord,
        ]);
    }

    // ワードランキング表示
    public function showWordRank($searchWord, Request $request){
        // sessionからwordRankを取得
        $wordRank = $request->session()->get('wordRank');
        // 配列→コレクションに変更
        $wordRank = collect($wordRank);
        // 1ページに表示する単語の数
        $disp_limit = 10;
        // paginate処理
        $wordRank = new LengthAwarePaginator(
            $wordRank -> forPage($request->page, $disp_limit), 
            count($wordRank), 
            $disp_limit, 
            $request->page, 
            array('path' => $request->url())
        );
        // 全ての単語を表示
        return view('showWordRank',[
            'searchWord' => $searchWord,
            'status' => null,
            'wordRank' => $wordRank,
        ]);
    }

    // ポジティブワードランキング表示
    public function showPositiveWordRank($searchWord, Request $request){
        // sessionからpositiveWordRankを取得
        $wordRank = $request->session()->get('positiveWordRank');
        // $wordRankがnullでなければ処理を行う,nullだったらそのままnullを返す
        if($wordRank != null){
            // 配列→コレクションに変更
            $wordRank = collect($wordRank);
            // 1ページに表示する単語の数
            $disp_limit = 10;
            // paginate処理
            $wordRank = new LengthAwarePaginator(
                $wordRank -> forPage($request->page, $disp_limit), 
                count($wordRank), 
                $disp_limit, 
                $request->page, 
                array('path' => $request->url())
            );
        }
        // positiveツイートに含まれている単語を表示
        return view('showWordRank',[
            'searchWord' => $searchWord,
            'status' => 'Positive',
            'wordRank' => $wordRank,
        ]);
    }

    // ニュートラルワードランキング表示
    public function showNeutralWordRank($searchWord, Request $request){
        // sessionからwordRankを取得
        $wordRank = $request->session()->get('neutralWordRank');
        // $wordRankがnullでなければ処理を行う,nullだったらそのままnullを返す
        if($wordRank != null){
            // 配列→コレクションに変更
            $wordRank = collect($wordRank);
            // 1ページに表示する単語の数
            $disp_limit = 10;
            // paginate処理
            $wordRank = new LengthAwarePaginator(
                $wordRank -> forPage($request->page, $disp_limit), 
                count($wordRank), 
                $disp_limit, 
                $request->page, 
                array('path' => $request->url())
            );
        }
        // neutralツイートに含まれている単語を表示
        return view('showWordRank',[
            'searchWord' => $searchWord,
            'status' => 'Neutral',
            'wordRank' => $wordRank,
        ]);
    }

    // ネガティブワードランキング表示
    public function showNegativeWordRank($searchWord, Request $request){
        // sessionからwordRankを取得
        $wordRank = $request->session()->get('negativeWordRank');
        // $wordRankがnullでなければ処理を行う,nullだったらそのままnullを返す
        if($wordRank != null){
            // 配列→コレクションに変更
            $wordRank = collect($wordRank);
            // 1ページに表示する単語の数
            $disp_limit = 10;
            // paginate処理
            $wordRank = new LengthAwarePaginator(
                $wordRank -> forPage($request->page, $disp_limit), 
                count($wordRank), 
                $disp_limit, 
                $request->page, 
                array('path' => $request->url())
            );
        }
        // negativeツイートに含まれている単語を表示
        return view('showWordRank',[
            'searchWord' => $searchWord,
            'status' => 'Negative',
            'wordRank' => $wordRank,
        ]);
    }
}
