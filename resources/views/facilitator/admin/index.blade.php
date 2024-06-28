@extends('layout.layout')

@section('title')
    Admininstrator
@endsection

@section('searchBar')
    @include("facilitator.admin.searchAdmin")
@endsection

@section('content')

    @if (session('adminCreated'))
        <div class="alert alert-success" role="alert">
            {{ session('adminCreated') }}
        </div>
    @endif

    @if (session('adminDeleted'))
        <div class="alert alert-danger" role="alert">
            {{ session('adminDeleted') }}
        </div>
    @endif
    @if (session('adminCreateErr'))
        <div class="alert alert-danger" role="alert">
            {{ session('adminCreateErr') }}
        </div>
    @endif
    
    @if (session('adminUpdated'))
        <div class="alert alert-warning" role="alert">
            {{ session('adminUpdated') }}
        </div>
    @endif

    @if ($admins->count() > 0)
        <div class="card w-100">
            <div class="card-body px-3 pt-3">
                <h5 class="card-title">Admininstrators
                    <span class="float-end">
                        @include('facilitator.admin.addNewAdmin')
                    </span>
                </h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Date created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr>
                                <td>{{ $admin->username }}
                                    @if ($admin->username == session('username'))
                                        <div class="d-flex gap-2 align-items-center float-end">
                                            <li class="fa fa-user"></li>
                                            <span>You</span>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ substr($admin->created_at, 0, 10) }}</td>
                                <td class="d-flex gap-2">
                                    @include('facilitator.admin.editAdmin')
                                    @include('facilitator.admin.deleteAdmin')
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$admins->links()}}
            </div>
        </div>
    @else
    <div class="mt-5 d-flex flex-column align-items-center gap-1">
        <li class="fa fa-user" style="font-size: 50px"></li>
        <h2 class="text-center">Nothing to show</h2>
    </div>
    @endif
@endsection




@section('mainScript')
    <script type="module">
        $(document).ready(function() {
            $('#adminSubmit').submit(function(event) {
                $(this).find('button[type="submit"]').prop('disabled', true);
                $(this).find('button[type="submit"]').find('.spinner-border').removeClass('d-none');
                $(this).find('span:nth-child(2)').text("Submitting...");
            });
           
            $('.adminEdit').submit(function(event) {
                $(this).find('button[type="submit"]').prop('disabled', true);
                $(this).find('button[type="submit"]').find('.spinner-border').removeClass('d-none');
                $(this).find('span:nth-child(2)').text("Updating...");
            });
            
            $('.adminDelete').submit(function(event) {
                $(this).find('button[type="submit"]').prop('disabled', true);
                $(this).find('button[type="submit"]').find('.spinner-border').removeClass('d-none');
                $(this).find('span:nth-child(2)').text("Deleting...");
            });
        });
    </script>
@endsection
