## Tweets-matomeとは
- 自分が知りたいことに対するTwitter上の反応をまとめてくれるアプリ

## 具体的に何ができるのか
- ツイートの検索と表示ができる
- 検索結果に対するポジティブ,ニュートラル,ネガティブの割合を知ることができる
- 検索結果をポジティブツイート,ニュートラルツイート,ネガティブツイートに分けて表示できる
- 検索したワードが,どういった単語と共にツイートされていたかをランキング形式で知ることができる
- ポジティブツイート,ニュートラルツイート,ネガティブツイート別に,どういった単語と共にツイートされていたかをランキング形式で知ることができる

## 使い方
- 検索ワードの入力, 検索
- 結果の閲覧
- 目的に応じて詳細表示
- RT順,いいね順,時系列順に並べ替え

## 開発環境
#### Local
- Docker
#### 本番
- Heroku

## 使用技術
#### Laravel
#### Python
(基本的にLaravelで構築し、ツイートの解析処理はPython)

## その他使用技術
#### オープンソース形態素解析エンジン
MeCab(http://taku910.github.io/mecab/#feature)
#### MeCabのPythonラッパー
mecab-python3(https://github.com/SamuraiT/mecab-python3)
#### Sentiment Analysis (いわゆるネガポジ判定) ライブラリ
oseti(https://github.com/ikegami-yukino/oseti)

## Twitter API
#### Python library
- tweepy(https://www.tweepy.org)
#### PHP library
- TwitterOAuth(https://twitteroauth.com)

