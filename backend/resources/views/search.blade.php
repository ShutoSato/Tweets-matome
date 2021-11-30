@extends('layout')

@section('content')
<div class="container">
    <h4>ツイート検索</h4>
    <form action="executePython" method="post">
        @csrf
        <input type="text" name="searchWord" placeholder="Search Word">
        <input type="submit" name="submit" value="検索">
    </form>
</div>
@endsection
