@extends('layouts.app')

@section('title', __('common.admin_panel'))

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h2>{{ __('common.admin_panel') }}</h2>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-lg">
                        {{ __('common.user_management') }}
                    </a>
                    <a href="{{ route('admin.conferences.index') }}" class="btn btn-success btn-lg">
                        {{ __('common.conference_management') }}
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-secondary">
                        {{ __('common.home') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

