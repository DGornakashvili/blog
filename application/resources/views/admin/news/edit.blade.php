@extends('layouts.app')

@section('content')
<div class="container">
    <news-form v-bind:id="{{ $id }}"></news-form>
</div>
@endsection
