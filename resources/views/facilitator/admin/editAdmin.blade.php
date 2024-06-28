<!-- Button trigger modal -->
<button type="button" class="btn btn-outline-success btn btn-sm" data-bs-toggle="modal" data-bs-target="#editAdmin-{{$admin->id}}">
    <li class="fa fa-edit"></li>
</button>

<!-- Modal -->
<div class="modal fade" id="editAdmin-{{$admin->id}}" tabindex="-1" aria-labelledby="editAdminLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAdminLabel">Account update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="post" action="{{ route('admin.update', [
            "admin" => $admin->id
            ]) }}" class="adminEdit" adminID="{{$admin->id}}">
                @csrf
                @method('put')
                <div class="modal-body">
                    @if ($admin->username !== session("username"))
                    <div class="alert alert-warning"><span class="fw-bold">Note: </span>Account owner permission is advised.</div>
                    @endif
                    <div class="mb-3">
                        <label for="username-{{$admin->id}}" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username-{{$admin->id}}" placeholder="Enter username" name="username" value="{{$admin->username}}" autocomplete required>
                    </div>
                    <div class="mb-3">
                        <label for="password-{{$admin->id}}" class="form-label">New password</label>
                        <input type="password" class="form-control" id="password-{{$admin->id}}" placeholder="Enter new password" name="password" value="{{$admin->password}}" autocomplete required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn btn-sm" type="submit">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <span>Update</span>
                    </button>
                    <button type="button" class="btn btn-secondary btn btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- 
@section('mainScript')
    <script type="module">
        $(document).ready(function() {
            $('.adminEdit').submit(function(event) {
                const adminID = $(this).attr('adminID');
                $(this).find('button[type="submit"]').prop('disabled', true);
                $(this).find('button[type="submit"]').find('.spinner-border').removeClass('d-none');
                $(this).find('span:nth-child(2)').text("Updating...");
            });
        });
    </script>
@endsection --}}