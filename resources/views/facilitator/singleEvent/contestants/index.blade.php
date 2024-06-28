@extends('layout.eventLayout')

@section('eventContent')
    <div class="w-100 p-2">
        @if (session('contestantCreateErr'))
            <div class="alert alert-danger" role="alert">
                {{ session('contestantCreateErr') }}
            </div>
        @endif
        <div class="card w-100 mt-2 mb-3">
            <div class="card-body px-3 pt-3">
                <h5 class="card-title">Contestants list
                    <span class="float-end">
                        @include('facilitator.singleEvent.contestants.addContestantModal')
                    </span>
                </h5>
                @if ($contestants->count() > 0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Name</th>
                                <th class="d-none d-md-table-cell">Address</th>
                                <th class="d-none d-md-table-cell">Age</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contestants as $contestant)
                                <tr>
                                    <th>{{ $contestant->contestantNum }}</th>
                                    <td>{{ $contestant->name }}</td>
                                    <td class="d-none d-md-table-cell">{{ $contestant->address }}</td>
                                    <td class="d-none d-md-table-cell">{{ $contestant->age }}</td>
                                    <td class="d-flex">
                                        <div>
                                            @include('facilitator.singleEvent.contestants.editContestant')
                                        </div>

                                        <div>
                                            @include('facilitator.singleEvent.contestants.deleteContestant')
                                        </div>

                                        <div>
                                            @include('facilitator.singleEvent.contestants.viewContestant')
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $contestants->links() }}
                @else
                    <div class="w-100 d-flex flex-column align-items-center mt-4 gap-2">
                        <li class="fa fa-user" style="font-size: 80px; font-weight: bold; color: gray;"></li>
                        <h5>No contestant added</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection




@section('mainScript')
    <script type="module">
        $(document).ready(function() {


            $(".addPhoto").change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    $("#photoHolder").removeClass().addClass('w-100 h-100 p-2 ');
                    $("#photoLabel").addClass('d-none');
                    reader.onload = function(e) {
                        $('#file-preview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            })

            $(".photo-picker").change(function() {
                const imgID = $(this).attr('imgID');
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#file-preview-' + imgID).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            })

            $('.submitContestant').submit(function() {
                $(this).find('button[type="submit"]').prop('disabled', true);
                $(this).find('button[type="submit"]').find('.spinner-border').removeClass('d-none');
                $(this).find('span:nth-child(2)').text("Submitting...");
            })

            $('.deleteContestant').submit(function() {
                $(this).find('button[type="submit"]').prop('disabled', true);
                $(this).find('button[type="submit"]').find('.spinner-border').removeClass('d-none');
                $(this).find('span:nth-child(2)').text("Deleting...");
            })

            $('.editContestant').submit(function() {
                $(this).find('button[type="submit"]').prop('disabled', true);
                $(this).find('button[type="submit"]').find('.spinner-border').removeClass('d-none');
                $(this).find('span:nth-child(2)').text("Updating...");
            })
        });
    </script>
@endsection
