<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Vender\executePython;

class PythonController extends Controller
{
    // Python処理
    public function executePython(Request $request) {
        // 検索ワードの取得
        $searchWord = $request->searchWord;
        // 取得するツイート数
        $NumberOfTweets = 20;
        // Python処理の呼び出し
        $excutePython = new executePython($searchWord, $NumberOfTweets, $request);
        // Python処理実行、結果を$resultに格納
        $result = $excutePython->executePython($request);
        // もしツイートが見つからなかったら
        if($result['NumberOfTweets'] == 0){
            $request->session()->put('NumberOfTweets', 0);
            return redirect()->route('showResult', [
                'searchWord' => $searchWord,
            ]);
        }
        // redirect
        return redirect()->route('showResult', [
            'searchWord' => $searchWord,
        ]);
    }
}