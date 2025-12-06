@extends('layouts.app')

@section('title', __('common.home'))

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h2>{{ __('common.student_info') }}</h2>
            </div>
            <div class="card-body">
                <p><strong>{{ __('common.student_name') }}:</strong> Tautvydas</p>
                <p><strong>{{ __('common.student_surname') }}:</strong> Kasperavičius</p>
                <p><strong>{{ __('common.student_group') }}:</strong> PIT-22-I-NT</p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h3>{{ __('common.role_systems') }}</h3>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('client.index') }}" class="btn btn-primary btn-lg">
                        {{ __('common.client_system') }}
                    </a>
                    <a href="{{ route('employee.index') }}" class="btn btn-success btn-lg">
                        {{ __('common.employee_system') }}
                    </a>
                    <a href="{{ route('admin.index') }}" class="btn btn-warning btn-lg">
                        {{ __('common.admin_system') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

