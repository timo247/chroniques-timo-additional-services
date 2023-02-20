@extends('template')
@section('contenu')
<h1>Error page</h1>
@if(isset($errorMessage))
<span>{{ $errorMessage }}</span>
@endsection