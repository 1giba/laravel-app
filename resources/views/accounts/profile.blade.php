@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-pencil-alt"></i> @lang('accounts.edit_profile')
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('profile') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3">@lang('accounts.full_name')</label>
                            <div class="col-md-9">
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                                <span class="help-block">@lang('accounts.full_name_help')</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3">@lang('accounts.email')</label>
                            <div class="col-md-9">
                                <input type="email" name="email" value="{{ $user->email }}" class="form-control" required><span class="help-block">@lang('accounts.email_help')</span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="form-group row">
                        <div class="col-md-9 offset-md-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> @lang('app.save')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection