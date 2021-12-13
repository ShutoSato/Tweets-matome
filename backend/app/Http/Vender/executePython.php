<?php

namespace App\Http\Vender;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Vender\CallTwitterApi;

class executePython
{
    public $searchWord;
    public $NumberOfTweets;
    
    // 検索ワードとリクエストの取得
    public function __construct($searchWord, $NumberOfTweets, Request $request)
    {
        $validated = $request->validate([
            'searchWord' => 'required',
        ]);
        $this->searchWord = $searchWord;
        $this->NumberOfTweets = $NumberOfTweets;
    }

    // Python処理
    public function executePython(Request $request) {  
        // Pythonのファイルがあるパスを設定
        $path = app_path() . "/Python/TweetsAnalytics.py";
        // コマンドの作成
        $command = "export LANG=ja_JP.UTF-8; python " . $path . " " . $this->searchWord  . " " . $this->NumberOfTweets;
        // python実行コマンド, 結果を$outputsに詰めてくれる, $rtnにstatusを返す
        exec($command, $outputs, $rtn);
        // ------ $outputsを使いやすく分ける ------
        // twitterApi呼び出し
        $twitterApi = new CallTwitterApi();
        // tweetDataを格納
        $startLine = 3;
        $finishLine = $startLine + ($this->NumberOfTweets*4);
        for( $i=$startLine; $i<$finishLine; $i=$i+4){
            // $outputs[$i] == null だったら、ツイートが存在しないか、設定したツイート数よりも少ない
            if($outputs[$i] == null){
                if($i==$startLine){ // もしツイートが存在しなかったら
                    $this->NumberOfTweets = 0; // 取得ツイート数に0を入れる
                    return [
                        'NumberOfTweets' => $this->NumberOfTweets // 取得ツイート数を返す
                    ];
                }else{ // 指定の数よりもツイートが少なかったら
                    $finishLine = $i; // $finishLineを設定し直す
                    $this->NumberOfTweets = ($finishLine - $startLine) / 4; // 取得ツイート数を設定し直す
                    break;
                }
            }else{
                // tweetIdを格納
                $tweetId = $outputs[$i];
                // Tweetをhtml形式に直して格納
                $tweetHtml = array($twitterApi->statusesOembed($tweetId));
                // ネガポジの値を格納
                $negaPosiValue = round($outputs[$i+1],5); // 5桁
                // $tweetsDatas[]に, [tweetId, tweetHtml, ネガポジ値, 判定内容, RT数, いいね数] を格納する
                $tweetsData[] = [
                    'tweetId' => $outputs[$i],
                    'tweetHtml' => $tweetHtml,
                    'negaPosiValue' => $negaPosiValue,
                    'negaPosiDetail' => null,
                    'RT_count' => null,
                    'fav_count' => null,
                ];
            }
        }
        // ネガポジ判定内容の詳細を格納
        $startLine = $finishLine + 3;
        for($i=0;$i<$this->NumberOfTweets;$i++){
            $NumberOfNegaPosiDetail = (int)$outputs[$startLine-1];
            for($n=0;$n<$NumberOfNegaPosiDetail;$n++){
                $negaPosiDetail[] = $outputs[$startLine + $n];
            }
            $tweetsData[$i]['negaPosiDetail'] = $negaPosiDetail;
            $negaPosiDetail = null;
            $finishLine = $startLine + $NumberOfNegaPosiDetail;
            $startLine = $finishLine + 2;
        }
        // ネガポジ別にtweet数を格納
        $startLine = $finishLine + 4;
        $finishLine = $startLine + 3;
        $NumberOfPositiveTweets = (int)$outputs[$startLine];
        $NumberOfNeutralTweets = (int)$outputs[$startLine+1];
        $NumberOfNegativeTweets = (int)$outputs[$startLine+2];
        // ネガポジ割合の値を格納
        $startLine = $finishLine + 2;
        $finishLine = $startLine + 3;
        for($i=$startLine; $i<$finishLine; $i++){
            $negaPosiPer[] = $outputs[$i];
        }
        // ---- ネガポジ別にtweetDataを格納 ----
        foreach($tweetsData as $tweetData){
            if($tweetData['negaPosiValue']>0){
                $positiveTweetsData[] = $tweetData;
            }elseif($tweetData['negaPosiValue']==0){
                $neutralTweetsData[] = $tweetData;
            }elseif($tweetData['negaPosiValue']<0){
                $negativeTweetsData[] = $tweetData;
            }
        }
        // もしポジティブツイートがなければnull
        if($NumberOfPositiveTweets == 0){
            $positiveTweetsData = null;
        }
        // もしニュートラルツイートがなければnull
        if($NumberOfNeutralTweets == 0){
            $neutralTweetsData = null;
        }
        // もしネガティブツイートがなければnull
        if($NumberOfNegativeTweets == 0){
            $negativeTweetsData = null;
        }
        
        // ---- ツイートに含まれる単語のランキングを格納 ----
        $startLine = $finishLine + 3;
        $NumberOfWords = (int)$outputs[$startLine-1];
        $finishLine = $startLine + $NumberOfWords;
        for($i=$startLine; $i<$finishLine; $i++){
            $wordRank[] = $outputs[$i];
        }
        // positiveツイートに含まれる単語のランキングを格納
        $startLine = $finishLine + 3;
        $NumberOfWords = (int)$outputs[$startLine-1];
        $finishLine = $startLine + $NumberOfWords;
        if($NumberOfWords == 0){
            $positiveWordRank = null;
        }else{
            for($i=$startLine; $i<$finishLine; $i++){
                $positiveWordRank[] = $outputs[$i];
            }
        }
        // neutralツイートに含まれる単語のランキングを格納
        $startLine = $finishLine + 3;
        $NumberOfWords = (int)$outputs[$startLine-1];
        $finishLine = $startLine + $NumberOfWords;
        if($NumberOfWords == 0){
            $neutralWordRank = null;
        }else{
            for($i=$startLine; $i<$finishLine; $i++){
                $neutralWordRank[] = $outputs[$i];
            }
        }
        // negativeツイートに含まれる単語のランキングを格納
        $startLine = $finishLine + 3;
        $NumberOfWords = (int)$outputs[$startLine-1];
        $finishLine = $startLine + $NumberOfWords;
        if($NumberOfWords == 0){
            $negativeWordRank = null;
        }else{
            for($i=$startLine; $i<$finishLine; $i++){
                $negativeWordRank[] = $outputs[$i];
            }
        }
        // sessionに値があれば削除
        $request->session()->flush();
        // sessionに各値を保存
        $request->session()->put('NumberOfTweets', $this->NumberOfTweets);
        $request->session()->put('negaPosi', $negaPosiPer);
        $request->session()->put('tweetsData', $tweetsData);
        $request->session()->put('positiveTweetsData', $positiveTweetsData);
        $request->session()->put('neutralTweetsData', $neutralTweetsData);
        $request->session()->put('negativeTweetsData', $negativeTweetsData);
        $request->session()->put('defaultTweetsData', $tweetsData);
        $request->session()->put('defaultPositiveTweetsData', $positiveTweetsData);
        $request->session()->put('defaultNeutralTweetsData', $neutralTweetsData);
        $request->session()->put('defaultNegativeTweetsData', $negativeTweetsData);
        $request->session()->put('wordRank', $wordRank);
        $request->session()->put('positiveWordRank', $positiveWordRank);
        $request->session()->put('neutralWordRank', $neutralWordRank);
        $request->session()->put('negativeWordRank', $negativeWordRank);
        // return
        return [
            'NumberOfTweets' => $this->NumberOfTweets,
        ];
    }
}