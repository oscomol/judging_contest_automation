<!-- Button trigger modal -->
<button type="button" class="btn btn-outline-danger btn btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAdmin-{{$admin->id}}">
    <li class="fa fa-trash"></li>
</button>

<!-- Modal -->
<div class="modal fade" id="deleteAdmin-{{$admin->id}}" tabindex="-1" aria-labelledby="deleteAdminLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAdminLabel">Confirm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="post" action="{{ route('admin.delete', [
            'admin' => $admin->id
            ])}}" class="adminDelete" adminID="{{$admin->id}}">
                @csrf
                @method('delete')
                <div class="modal-body">
                    <input type="hidden" value="{{$admin->username}}" name="username">
                  <p>
                    Are you sure to delete @if (session('username') == $admin->username)
                        your account ?
                    @else
                    this account with username {{$admin->username}} ?
                    @endif
                  </p>
                <div class="modal-footer">
                    <button class="btn btn-danger btn btn-sm" type="submit">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <span>Yes</span>
                    </button>
                    <button type="button" class="btn btn-secondary btn btn-sm" data-bs-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>
