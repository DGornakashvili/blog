@extends('layouts.app')

@section('content')
<div class="container">
    <galleries-form v-bind:id="{{ $id }}"></galleries-form>
</div>
@endsection
