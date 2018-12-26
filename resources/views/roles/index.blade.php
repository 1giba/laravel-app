@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
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
                                    <th scope="col">@lang('app.created_at')</th>
                                    <th scope="col">@lang('app.updated_at')</th>
                                    <th scope="col">@lang('app.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    <th scope="row">{{ $role->id }}</th>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->present()->createdAt }}</td>
                                    <td>{{ $role->present()->updatedAt }}</td>
                                    <td>
                                        <a href="{{  url('/roles', $role->id) }}/permissions"><i class="fa fa-ellipsis-h" alt="@lang('roles.permissions')"></i></a>&nbsp;
                                        <a href="{{ url('/roles', $role->id) }}"><i class="fa fa-edit" alt="@lang('roles.edit')"></i></a>&nbsp;
                                        <a href="#" data-toggle="modal" data-target="#deleteModal" data-resource-id="{{ $role->id }}" data-action="{{ url('/roles', $role->id) }}" data-title="@lang('roles.delete')" data-message="@lang('roles.delete_message')"><i class="fa fa-trash" alt=""></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $roles->links() }}
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
