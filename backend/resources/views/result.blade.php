@extends('layout')

@section('content')
<div class="container">
    <div class="input-group mb-3 searchWord">
        <input type="text" class="form-control" aria-describedby="basic-addon1" value="🔍  {{$searchWord}}" disabled>
    </div>
    @if ($NumberOfTweets == -1)
        <div class="errorMessage">
            <p>申し訳ございません。</p>
            <p>"{{$searchWord}}" で検索した結果、</p>
            <p>予期せぬエラーが発生しました。</p>
            <p>時間を置いて頂くか、検索ワードを変えて再度お試し頂けると幸いです。</p>
        </div>
        <div class="backLink" style="margin-top: 20px;">
            <a href="{{ route('search')}}"> << 検索画面に戻る</a>
        </div>
    @elseif ($NumberOfTweets == 0)
        <div class="errorMessage">
            <p>"{{$searchWord}}" で検索した結果、</p>
            <p>ツイートは見つかりませんでした。</p>
        </div>
        <div class="backLink" style="margin-top: 20px;">
            <a href="{{ route('search')}}"> << 検索画面に戻る</a>
        </div>
    @else
        <div class="row">
            <div class="col col-md-12">
                <nav class="panel panel-default">
                    <div class="panel-heading">取得ツイート数</div>
                    <div class="list-group">
                        <a
                            href="{{ route('showAllTweets',[$searchWord]) }}"
                            class="list-group-item"
                        >
                            {{ $NumberOfTweets }}
                        </a>
                        <div class="list-group-item">
                            <a 
                                href="{{ route('showAllTweets',[$searchWord]) }}" 
                                class="showLink"
                                style="color: #3bafda;"
                            > 
                                >> ShowAllTweets 
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col col-md-12">
                <nav class="panel panel-default">
                    <div class="panel-heading">ネガポジ割合</div>
                    <div class="list-group">
                        <a href="{{ route('showPositiveTweets',[$searchWord]) }}" class="list-group-item"> 
                            {{ $negaPosi[0] }}
                        </a>
                        <a href="{{ route('showNeutralTweets',[$searchWord]) }}" class="list-group-item"> 
                            {{ $negaPosi[1] }}
                        </a>
                        <a href="{{ route('showNegativeTweets',[$searchWord]) }}" class="list-group-item"> 
                            {{ $negaPosi[2] }}
                        </a>
                        <div class="list-group-item" style="display: flex;">
                            <a href="{{ route('showPositiveTweets',[$searchWord]) }}" class="showLink" style="color: #3bafda;"> 
                                >> ShowPositiveTweets
                            </a> &emsp;
                            <a href="{{ route('showNeutralTweets',[$searchWord]) }}" class="showLink" style="color: #3bafda;"> 
                                >> ShowNeutralTweets
                            </a> &emsp;
                            <a href="{{ route('showNegativeTweets',[$searchWord]) }}" class="showLink" style="color: #3bafda;"> 
                                >> ShowNegativeTweets
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col col-md-12">
                <nav class="panel panel-default">
                    <div class="panel-heading">" {{$searchWord}} " と共にツイートされている単語 - Top10</div>
                    <div class="list-group">
                        @for($i=0; $i<10; $i++)
                            <a href="" class="list-group-item">
                                {{ $wordRank[$i] }}
                            </a>
                        @endfor
                        <div class="list-group-item">
                            <a href="{{ route('showWordRank',[$searchWord]) }}" class="showLink" style="color: #3bafda;"> 
                                >> ShowAllWords
                            </a> 
                        </div>
                        <div class="list-group-item">
                            <a href="{{ route('showPositiveWordRank',[$searchWord]) }}" class="showLink" style="color: #3bafda;"> 
                                >> PositiveTweets'Words
                            </a> &emsp;
                            <a href="{{ route('showNeutralWordRank',[$searchWord]) }}" class="showLink" style="color: #3bafda;"> 
                                >> NeutralTweets'Words
                            </a> &emsp;
                            <a href="{{ route('showNegativeWordRank',[$searchWord]) }}" class="showLink" style="color: #3bafda;"> 
                                >> NegativeTweets'Words
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    @endif
</div>
@endsection

