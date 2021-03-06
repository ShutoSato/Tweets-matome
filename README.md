## Tweets-matome
 http://tweets-matome.herokuapp.com

## Tweets-matomeとは
- 自分が知りたいことに対するTwitter上の反応をまとめてくれるアプリ

## 具体的に何ができるのか
- ツイートの検索と表示
- 検索結果に対するポジティブ,ニュートラル,ネガティブの割合を知ること
- 検索結果をポジティブツイート,ニュートラルツイート,ネガティブツイートに分けて表示
- 検索したワードが,どういった単語と共にツイートされていたかをランキング形式で知ること
- ポジティブツイート,ニュートラルツイート,ネガティブツイート別に,どういった単語と共にツイートされていたかをランキング形式で知ること

## 使い方
- 検索ワードの入力, 検索
- 結果の閲覧
- 目的に応じて詳細表示
- ツイートをRT順,いいね順,時系列順に並べ替え

## システム概要
- 基本的にLaravelで構築 
  - /Tweets-matome/backend/
- ツイートの解析処理だけPython
  - /Tweets-matome/backend/app/Python/TweetsAnalytics.py
  - 形態素解析はMeCab(mecab-python3)
  - ネガポジ判定はoseti
- TwitterAPIはTweepy,TwitterOAuth
- Local環境はDocker, 本番環境はHerokuで構築
- Docker
  - /Tweets-matome/docker-compose.yml
  - Dockerfile
    - /Tweets-matome/infra/
- Heroku
  - /Tweets-matome/heroku.yml

## 作成するにあたって工夫した点
- 実際に使うことを想定して作成した
  - シンプルで分かりやすい機能とデザイン
  - 検索結果からRTを除外することで同じツイートばかり取得しないように工夫
  - ネガポジ別の単語ランキングを作成することで、ネガティブな意見にはどういったものが多いのか等が分かる
  - 並び替え機能で支持されているツイートが分かる

## システム面で工夫した点
- なるべく読みやすいコードを心がけた
- 処理の重複を減らし、動作が重くならないようにした
- ツイート文を形態素解析し、単語を標準形に直すことでランキング化を可能にした

## 特に頑張ったファイル
- /Tweets-matome/backend/app/Python/TweetsAnalytics.py
  - ツイートの解析処理を行なっているファイル。
  - APIやライブラリの利用, それ以降の処理で使いやすい出力の仕方を頑張った。
- /Tweets-matome/backend/app/Http/Vender/executePython.php
  - pythonファイルの実行とその出力受け取りを行なっているファイル。
  - pythonでのツイート解析の出力結果が全て'$outputs'に入れて返されるので、変数や場合分けを用いてそれ以降の処理で使いやすいように出力結果を格納した。
  - 変数を用いることで、出力形式が変わっても簡単に対応できるようにした。

## 苦労した点
- 環境構築
  - 初めてDockerを扱ったので苦労した
  - また、Dockerでは機能していたのに、本番環境だと機能しないなどの点も苦労した
  - 特にライブラリやAPIを扱うための設定には手こずった
  - ドキュメントをしっかり読むことや、機能や使用方法を正しく理解することの大切さを痛感した

## 反省点
- Gitの使い方
  - バージョン管理をしっかりすべきだった
  - Local環境と本番環境のコードがごっちゃになってしまった
- 環境構築
  - 理解度が低いまま環境構築していた
    - 使わないものをインストールしていたり, 書き方が変なものがある(たぶん)
    - 経験が浅いため仕方ない部分もあるが、次回以降はもう少し理解しながら進める
- コード
  - 意識して減らしたが、冗長な箇所がまだいくつかある
  - そもそもDjango等で構築できれば良かった(システムの肝がpythonのため)(今回は時短のため経験のあったLaravelを使用)

## 備考
- システム動作の都合上、取得ツイート数は20に設定している


## 開発環境
#### Local
- Docker
#### 本番
- Heroku

## 使用技術
- Laravel
- Python
###### (基本的にLaravelで構築し、ツイートの解析処理はPython)

## その他使用技術
#### 形態素解析エンジン
- MeCab(http://taku910.github.io/mecab/#feature)
#### MeCabのPythonラッパー
- mecab-python3(https://github.com/SamuraiT/mecab-python3)
#### Sentiment Analysis (いわゆるネガポジ判定) ライブラリ
- oseti(https://github.com/ikegami-yukino/oseti)

## Twitter API
#### Python library
- Tweepy(https://www.tweepy.org)
#### PHP library
- TwitterOAuth(https://twitteroauth.com)

