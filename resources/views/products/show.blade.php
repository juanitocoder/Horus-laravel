@extends('layouts.app')

@section('content')
<div class="flex justify-center">
    
    <x-cartas :productos="$productos" />
</div>
@endsection