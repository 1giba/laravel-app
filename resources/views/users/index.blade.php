@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">@lang('users.index')</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('users.avatar_url')</th>
                                    <th scope="col">@lang('users.role')</th>
                                    <th scope="col">@lang('users.name')</th>
                                    <th scope="col">@lang('users.email')</th>
                                    <th scope="col">@lang('app.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td><img class="img-avatar row-img" src="{{ url($user->present()->avatar) }}"></td>
                                    <td>{{ ! $user->roles->isEmpty() ? $user->roles[0]->name : '' }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <a href="{{ url('/users', $user->id) }}/activities" alt="@lang('users.show_activities')"><i class="fa fa-search"></i></a>&nbsp;
                                        <a href="{{ url('/users', $user->id) }}"><i class="fa fa-edit" alt="@lang('users.edit')"></i></a>
                                        @if ($user->id != Auth::user()->id)
                                        &nbsp;<a href="#" data-toggle="modal" data-target="#deleteModal" data-resource-id="{{ $user->id }}" data-action="{{ url('/users', $user->id) }}" data-title="@lang('users.delete')" data-message="@lang('users.delete_message')"><i class="fa fa-trash" alt=""></i></a>
                                        @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('layouts.deleteModal')
</div>
@endsection

@section('javascript')
@include('layouts.deleteScript')
@endsection
