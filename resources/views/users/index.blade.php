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
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <a href="{{ url('/users', $user->id) }}/activities" alt="@lang('users.show_activities')"><i class="fa fa-search"></i></a>&nbsp;
                                        <a href="{{ url('/users', $user->id) }}"><i class="fa fa-edit" alt="@lang('users.edit')"></i></a>&nbsp;
                                        <a href="#" data-toggle="modal" data-target="#deleteUserModal" data-user-id="{{ $user->id }}" data-action="{{ url('/users', $user->id) }}" data-message="@lang('users.delete_message')"><i class="fa fa-trash" alt=""></i></a>
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
    <!-- Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">@lang('users.delete')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <div class="modal-body">
                <span id="deleteMessage"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('app.close')</button>
                <form method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">@lang('app.delete')</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    $('#deleteUserModal').on('show.bs.modal', function (event) {
        var link   = $(event.relatedTarget);
        var userId = link.data('user-id');
        var action = link.data('action');
        var message = link.data('message');

        message = message.replace(':id', userId);
        $('#deleteMessage')[0].innerText = message;
        $(this).find('.modal-footer form').attr('action', action);
    });
</script>
@endsection
