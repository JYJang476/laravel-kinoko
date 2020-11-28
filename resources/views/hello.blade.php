@extends('testpage')

@section('title')
@endsection

@section('content')

    @foreach($datas as $data)
        <div>{{$data["name"]}}</div>
    @endforeach
@endsection