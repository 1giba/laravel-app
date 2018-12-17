@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('roles.index')</div>

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
                                    <th scope="col">@lang('roles.name')</th>
                                    <th scope="col">@lang('roles.guard_name')</th>
                                    <th scope="col">@lang('app.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    <th scope="row">{{ $role->id }}</th>
                                    <td><img class="img-avatar row-img" src="{{ url($role->present()->avatar) }}"></td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->email }}</td>
                                    <td>
                                        <a href="{{ url('/roles', $role->id) }}"><i class="fa fa-edit" alt="@lang('roles.edit')"></i></a>&nbsp;
                                        <a href="{{ url('/roles', $role->id) }}"><i class="fa fa-trash" alt="@lang('roles.delete')"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
