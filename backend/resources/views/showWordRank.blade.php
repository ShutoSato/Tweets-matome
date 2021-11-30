@extends('layout')

@section('content')
<div class="container">
    <div class="backLink">
        <a href="{{ route('showResult',[$searchWord]) }}"> << 結果一覧に戻る</a>
    </div>
    @if($wordRank == null)
        <p>{{ $status }} ツイートがありませんでした。</p>
    @else
        <div class="row">
            <div class="col col-md-12">
                <nav class="panel panel-default">
                    @if($status == null)
                        <div class="panel-heading">" {{$searchWord}} " と共にツイートされている単語</div>
                    @else
                        <div class="panel-heading"> {{$status}} ツイートに含まれている単語</div>
                    @endif
                    <div class="list-group">
                        @foreach($wordRank as $word)
                            <a href="" class="list-group-item">
                                {{ $word }}
                            </a>
                        @endforeach
                    </div>
                </nav>
            {{ $wordRank->onEachSide(3)->links() }}
        </div>
        </div>
    @endif
</div>
@endsection
