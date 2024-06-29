@section('searchBar')

    <form action="/jca/events/search" method="GET">
        @csrf
        @method("GET")
        <div class="input-group d-none d-md-flex" style="width: 250px;">
            <input type="text" class="form-control" placeholder="Search event here" aria-label="Recipient's username" name="search" aria-describedby="button-addon2">
            <button class="btn btn-primary" type="submit" id="button-addon2">
                <li class="fa fa-search"></li>
            </button>
        </div>
    </form>


    <button type="button" class="btn btn-outline-dark border-0 d-md-none" data-bs-toggle="modal"
        data-bs-target="#searchEvent">
        <li class="fa fa-search"></li>
    </button>

    <div class="modal fade" id="searchEvent" tabindex="-1" aria-labelledby="addEventLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventLabel">Search event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="get" action="/jca/events/search">
                    @csrf
                    @method('get')
                    <div class="modal-body">
                        <input type="text" class="form-control" placeholder="Search" name="search">
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary btn btn-sm" value="Submit">
                        <button type="button" class="btn btn-secondary btn btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection