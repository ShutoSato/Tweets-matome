@extends('layout')

@section('content')
<div class="container">
    <h4>ツイート検索</h4>
    <form action="executePython" method="post">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    <li>検索ワードを入力してください</li>
                </ul>
            </div>
        @endif
        <input type="text" name="searchWord" placeholder="Search Word">
        <input type="submit" name="submit" value="検索">
    </form>
</div>
@endsection
