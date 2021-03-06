@extends('layout')

@section('content')
<div class="container">
    <div class="input-group mb-3 searchWord">
        <input type="text" class="form-control" aria-describedby="basic-addon1" value="๐  {{$searchWord}}" disabled>
    </div>
    @if ($NumberOfTweets == -1)
        <div class="errorMessage">
            <p>็ณใ่จณใใใใพใใใ</p>
            <p>"{{$searchWord}}" ใงๆค็ดขใใ็ตๆใ</p>
            <p>ไบๆใใฌใจใฉใผใ็บ็ใใพใใใ</p>
            <p>ๆ้ใ็ฝฎใใฆ้ ใใใๆค็ดขใฏใผใใๅคใใฆๅๅบฆใ่ฉฆใ้ ใใใจๅนธใใงใใ</p>
        </div>
        <div class="backLink" style="margin-top: 20px;">
            <a href="{{ route('search')}}"> << ๆค็ดข็ป้ขใซๆปใ</a>
        </div>
    @elseif ($NumberOfTweets == 0)
        <div class="errorMessage">
            <p>"{{$searchWord}}" ใงๆค็ดขใใ็ตๆใ</p>
            <p>ใใคใผใใฏ่ฆใคใใใพใใใงใใใ</p>
        </div>
        <div class="backLink" style="margin-top: 20px;">
            <a href="{{ route('search')}}"> << ๆค็ดข็ป้ขใซๆปใ</a>
        </div>
    @else
        <div class="row">
            <div class="col col-md-12">
                <nav class="panel panel-default">
                    <div class="panel-heading">ๅๅพใใคใผใๆฐ</div>
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
                    <div class="panel-heading">ใใฌใใธๅฒๅ</div>
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
                    <div class="panel-heading">" {{$searchWord}} " ใจๅฑใซใใคใผใใใใฆใใๅ่ช - Top10</div>
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

