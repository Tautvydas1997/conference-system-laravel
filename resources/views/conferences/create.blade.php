@extends('layouts.app')

@section('title', __('conferences.create'))

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h2>{{ __('conferences.create') }}</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.conferences.store') }}" method="POST">
                    @csrf
                    
                    @include('conferences._form', ['conference' => []])

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.conferences.index') }}" class="btn btn-secondary">
                            {{ __('common.cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            {{ __('conferences.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

