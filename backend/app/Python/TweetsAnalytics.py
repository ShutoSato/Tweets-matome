import sys
import MeCab
from collections import Counter
import oseti
import tweepy
import io
import os
from dotenv import load_dotenv

# .envファイルの内容を読み込む
load_dotenv()
# twitterApiKeyの取得
# os.environを用いて環境変数から取得
consumer_key = os.getenv('CONSUMER_KEY')
consumer_secret = os.getenv('CONSUMER_SECRET')
access_key = os.getenv('ACCESS_TOKEN')
access_secret = os.getenv('ACCESS_TOKEN_SECRET')
# tweepy準備
auth = tweepy.OAuthHandler(consumer_key, consumer_secret)
auth.set_access_token(access_key, access_secret)
api = tweepy.API(auth)
# Mecab(tokenizer)準備
tokenizer = MeCab.Tagger('-r/dev/null -d/home/hoge/mydic')
tokenizer.parse("")
#osetiの準備
analyzer = oseti.Analyzer()
#配列準備
Tweets = [] # ツイートを格納する配列
TweetsAnalytics = [] # 解析する用のツイートを格納する配列

# 検索ワードの取得
searchWord = sys.argv[1] # 検索ワード
NumberOfAllTweets = sys.argv[2] # 取得したいツイートの数
NumberOfAllTweets = int(NumberOfAllTweets)  # str型からint型に変換
searchCommand = searchWord + ' exclude:retweets'  # searchCommand = 検索ワード + 検索結果からRTを除外
negaPosiDefault = 0 # ネガポジのデフォルト値
contentsOfNegaPosiJudge = [] # ネガポジの判定内容
# ツイートの取得
for tweet in api.search_tweets(q=searchCommand, lang='ja', result_type='recent', count=NumberOfAllTweets, tweet_mode='extended'):
    Tweets.append([tweet.id, tweet.full_text, negaPosiDefault, contentsOfNegaPosiJudge])
    TweetsAnalytics.append(tweet.full_text)
# ツイート数の入れ直し
NumberOfAllTweets = len(Tweets)
# osetiで解析をかける
negaPosiResults = list(map(analyzer.analyze, TweetsAnalytics))
# 変数定義
NumberOfPositiveTweets = 0 # positiveツイートの数
NumberOfNeutralTweets = 0 # neutralツイートの数
NumberOfNegativeTweets = 0 # negativeツイートの数
negaPosiTotal = 0
i = 0
# ネガポジの値を計算する
for negaPosiResult in negaPosiResults:
    # negaPosiResultに文の数ぶん結果が格納されてるから、取り出して平均を出す
    for eachReault in negaPosiResult:
        negaPosiTotal = negaPosiTotal + eachReault # ネガポジの値をnegaPosiTotalに足していく
    negaPosiAve = negaPosiTotal / len(negaPosiResult) # 合計を文の数で割って、平均を格納
    Tweets[i][2] = negaPosiAve # ネガポジの値をTweets[]の3つ目に入れる
    Tweets[i][3] = negaPosiResult # ネガポジの判定内容をTweets[]の4つ目に入れる
    negaPosiTotal = 0 # totalを0に戻す
    # ネガポジごとのツイートの数を数える
    if negaPosiAve > 0:
        NumberOfPositiveTweets = NumberOfPositiveTweets + 1
    elif negaPosiAve == 0:
        NumberOfNeutralTweets = NumberOfNeutralTweets + 1
    elif negaPosiAve < 0:
        NumberOfNegativeTweets = NumberOfNegativeTweets + 1
    # 次のツイート
    i = i + 1
# ネガポジの値を算出、小数点は一桁まで
posiPer = round(NumberOfPositiveTweets / NumberOfAllTweets * 100, 1)
neutralPer = round(NumberOfNeutralTweets / NumberOfAllTweets * 100, 1)
negaPer = round(NumberOfNegativeTweets / NumberOfAllTweets * 100, 1)

# --------- 出力 --------------
# 検索ワードの出力
print(searchWord)
print()
# 取得したツイートの情報
print('== Tweet data ==')
for tweet in Tweets:
    print(tweet[0]) # id
    print(tweet[2]) # ネガポジ値
    print(tweet[3]) # ネガポジの判定内容
    print()
print('')
# ネガポジ判定内容の中身
print('== ネガポジ判定内容の中身 ==')
for tweet in Tweets:
    print(len(tweet[3])) # ネガポジ判定内容の中身の数
    for eachReault in tweet[3]:
        print(eachReault) # ネガポジ判定内容の中身を一文ずつ出力する
    print()
# 取得ツイート数
print('==取得ツイート数==')
print('Total: ' + str(NumberOfAllTweets) + 'tweets')
print('Positive: ' + str(NumberOfPositiveTweets) + ' , ' + 'Neutral: ' + str(NumberOfNeutralTweets) + ' , ' + 'Negative: ' + str(NumberOfNegativeTweets))
print(str(NumberOfPositiveTweets))
print(str(NumberOfNeutralTweets))
print(str(NumberOfNegativeTweets))
print()
# ネガポジ割合
print('==ネガポジ割合==')
print('Positive: ' + str(posiPer) + '%')
print('Neutral: ' + str(neutralPer) + '%')
print('Negative: ' + str(negaPer) + '%')


# --------- ここから単語ランキングの処理 --------------
wordCountOfAll = []  # 全体の単語の頻出度をカウントするためのlist
wordCountOfPosi = []  # positiveツイートのwordカウント
wordCountOfNeutral = []  # neutralツイートのwordカウント
wordCountOfNegative = []  # negativeツイートのwordカウント

for tweet in Tweets:
    # nodeにtweet[1](ツイート文)をtokenizer(MeCab)による形態素解析でバラバラにして格納する
    node = tokenizer.parseToNode(tweet[1])
    # ネガポジ判定結果をnegaPosiAveに入れる
    negaPosiAve = tweet[2]
    # 単語の格納
    while node:
        if len(node.surface) >= 2: # 2文字以上のみ格納する
            if node.surface != searchWord: # 検索ワードは含まないようにする
                if node.surface != 'https' and node.surface != '://' and  node.surface != 'co': # urlは含まないようにする
                    if node.feature.split(",")[0] == u"名詞":
                        wordCountOfAll.append(node.surface)
                        # ネガポジ判定の結果によって、ワードカウントの格納を分ける
                        if negaPosiAve > 0:
                            wordCountOfPosi.append(node.surface)
                        elif negaPosiAve == 0:
                            wordCountOfNeutral.append(node.surface)
                        elif negaPosiAve < 0:
                            wordCountOfNegative.append(node.surface)
                    elif node.feature.split(",")[0] == u"形容詞":
                        wordCountOfAll.append(node.feature.split(",")[6])
                        # ネガポジ判定の結果によって、ワードカウントの格納を分ける
                        if negaPosiAve > 0:
                            wordCountOfPosi.append(node.feature.split(",")[6])
                        elif negaPosiAve == 0:
                            wordCountOfNeutral.append(node.feature.split(",")[6])
                        elif negaPosiAve < 0:
                            wordCountOfNegative.append(node.feature.split(",")[6])
                    elif node.feature.split(",")[0] == u"動詞":
                        wordCountOfAll.append(node.feature.split(",")[6])
                        # ネガポジ判定の結果によって、ワードカウントの格納を分ける
                        if negaPosiAve > 0:
                            wordCountOfPosi.append(node.feature.split(",")[6])
                        elif negaPosiAve == 0:
                            wordCountOfNeutral.append(node.feature.split(",")[6])
                        elif negaPosiAve < 0:
                            wordCountOfNegative.append(node.feature.split(",")[6])
        node = node.next

# --------- 出力 --------------
# 単語ランキングの表示
print()
print('＝＝ "{0}" と共にツイートされている単語＝＝'.format(searchWord))
count = Counter(wordCountOfAll) # 単語のカウント
sortCount = count.most_common() # 降順にソート
print(len(sortCount)) # 単語の数(重複なし)の取得
for wordAndCount in sortCount:
    print(' " {0} " : {1}'.format(wordAndCount[0], wordAndCount[1]))

# positiveツイートの単語ランキング表示
print()
print('＝＝ Positiveツイートの単語ランキング ＝＝')
count = Counter(wordCountOfPosi) # 単語のカウント
sortCount = count.most_common() # 降順にソート
print(len(sortCount)) # 単語の数(重複なし)の取得
for wordAndCount in sortCount:
    print(' " {0} " : {1}'.format(wordAndCount[0], wordAndCount[1]))

# neutralツイートの単語ランキング表示
print()
print('＝＝ Neutralツイートの単語ランキング ＝＝')
count = Counter(wordCountOfNeutral) # 単語のカウント
sortCount = count.most_common() # 降順にソート
print(len(sortCount)) # 単語の数(重複なし)の取得
for wordAndCount in sortCount:
    print(' " {0} " : {1}'.format(wordAndCount[0], wordAndCount[1]))

# negativeツイートの単語ランキング表示
print()
print('＝＝ Negativeツイートの単語ランキング ＝＝')
count = Counter(wordCountOfNegative) # 単語のカウント
sortCount = count.most_common() # 降順にソート
print(len(sortCount)) # 単語の数(重複なし)の取得
for wordAndCount in sortCount:
    print(' " {0} " : {1}'.format(wordAndCount[0], wordAndCount[1]))