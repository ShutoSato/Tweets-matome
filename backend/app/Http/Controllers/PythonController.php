<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PythonController extends Controller
{
    public function index() {
        return view('index');
    }
    public function executePython(Request $request) {
        // 検索ワードの取得
        $searchWord = $request->searchWord;
        // Pythonのファイルがあるパスを設定
        $path = app_path() . "/Python/sample.py";
        // コマンドの作成
        $command = "python " . $path . " sample1　" . $searchWord;
        // python実行コマンド, 結果を$outputsに詰めてくれる, $rtnにstatusを返す
        exec($command, $outputs, $rtn);
        // ddで出力
        dd($outputs, $command, $rtn);
    }
}