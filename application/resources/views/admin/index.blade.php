@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Sections') }}</div>

                <div class="card-body">
                    <a href="{{ route('admin.news.index') }}">{{ __('News list') }}</a>
                </div>

                <div class="card-body">
                    <a href="{{ route('admin.galleries.index') }}">{{ __('Gallery list') }}</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
