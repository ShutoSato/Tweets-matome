@extends('layout')

@section('content')
<div class="container">
    <div class="backLink">
        <a href="{{ route('showResult',[$searchWord]) }}"> << 結果一覧に戻る</a>
    </div>
    <div class="input-group mb-3 searchWord">
        <input type="text" class="form-control" aria-describedby="basic-addon1" value="🔍  {{$searchWord}}" disabled>
    </div>
    @if ($tweets == null)
        <p>{{ $status }} ツイートは見つかりませんでした。</p>
    @else
        @if($status == null)
            <p style="margin-bottom: 10px;">&emsp;- 全てのツイートを表示中</p>
            &emsp;-
            @if($show == 'detail')
                <a href="{{ route('showAllTweets',[$searchWord, 'page'=>$page]) }}">
                    判定詳細を閉じる
                </a>
            @else
                <a href="{{ route('showAllTweets',[$searchWord, 'page'=>$page, 'show'=>'detail']) }}">
                    判定詳細を見る
                </a>
            @endif
            <p style="margin-bottom: 10px;"></p>
            &emsp;- ツイートを並び替える 【
            <a href="{{ route('showAllTweets',[$searchWord, 'sort'=>'time', 'show'=>$show]) }}">時系列</a>,
            <a href="{{ route('showAllTweets',[$searchWord, 'sort'=>'RT_count', 'show'=>$show]) }}">&emsp;RT順</a>,
            <a href="{{ route('showAllTweets',[$searchWord, 'sort'=>'fav_count', 'show'=>$show]) }}">&emsp;いいね順</a> 】
            <p style="margin-bottom: 10px;"></p>
        @else
            <p style="margin-bottom: 10px;">&emsp;- {{ $status }} ツイートのみを表示中</p>
            &emsp;-
            @if($show == 'detail')
                <a href="{{ route('show'.$status.'Tweets',[$searchWord, 'page'=>$page]) }}">
                    判定詳細を閉じる
                </a>
            @else
                <a href="{{ route('show'.$status.'Tweets',[$searchWord, 'page'=>$page, 'show'=>'detail']) }}">
                    判定詳細を見る
                </a>
            @endif
            <p style="margin-bottom: 10px;"></p>
            &emsp;- ツイートを並び替える 【
            <a href="{{ route('show'.$status.'Tweets',[$searchWord, 'sort'=>'time', 'show'=>$show]) }}">時系列</a>,
            <a href="{{ route('show'.$status.'Tweets',[$searchWord, 'sort'=>'RT_count', 'show'=>$show]) }}">&emsp;RT順</a>,
            <a href="{{ route('show'.$status.'Tweets',[$searchWord, 'sort'=>'fav_count', 'show'=>$show]) }}">&emsp;いいね順</a> 】
            <p style="margin-bottom: 10px;"></p>
        @endif
        @foreach($tweets as $tweet)
            <div class="row">
                <div class="col col-md-7">
                    {!! $tweet['tweetHtml'][0] !!}
                </div>
                <div class="col col-md-5">
                    @if($show == 'detail')
                            <p style="margin-bottom: 7rem;"></p>
                            <h4>判定結果: {{$tweet['negaPosiValue']}}</h4>
                            ----------------------------
                            @for($i=0;$i<count($tweet['contentsOfNegaPosiJudge']);$i++)
                                <p style="margin-bottom: 0;">&emsp;- {{$i+1}}文目: {{ $tweet['contentsOfNegaPosiJudge'][$i] }}</p>
                            @endfor
                            ----------------------------
                    @endif
                </div>
            </div>
        @endforeach
        @if($show == 'detail')
            {{ $tweets->appends(['show'=>'detail'])->onEachSide(3)->links() }}
        @else
            {{ $tweets->onEachSide(3)->links() }}
        @endif
    @endif
</div>
@endsection
