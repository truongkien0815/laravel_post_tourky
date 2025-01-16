@extends($templatePath .'.layout')

@section('content')
    
    {!! htmlspecialchars_decode($page->content) !!}

@endsection