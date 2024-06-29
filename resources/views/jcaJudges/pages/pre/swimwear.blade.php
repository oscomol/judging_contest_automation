@extends('layout.judgesLayout')

@section('judgesNavs')
<nav class="navbar navbar-expand-md shadow-none" style="background: #cc9767;">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('preliminary.index') }}">Preliminary</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('swimwear.index') ? 'active' : '' }}" aria-current="page" href="{{ route('swimwear.index') }}">Swimwear</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
@endsection


@section('judgesCont')
    <form action="{{ route('swimwearScore') }}" method="POST" id="addSwimwear">

        <div class="p-0">
            @if ($isRecorded)
                <h5 class="text-center">Respond recorded succesfully. Thank you for your participation!</h5>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Rating sheet
                        <span class="float-end">
                            @if ($isRecorded)
                            <button type="button" class="btn btn-primary btn btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editrate">
                                Update
                            </button>
                        @else
                        <button type="submit" id="swimwearSubmitButton" class="btn btn-primary btn btn-sm" disabled>Submit</button>
                        @endif
                        </span>
                    </h3>
                    <input type="hidden" value="{{session('access_code')}}" id="accessCode">
                </div>

                <div class="card-body p-0">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Contestants</th>
                                <th scope="col">Suitability (50%)</th>
                                <th scope="col">Poise and Projection (50%)</th>
                                <th scope="col">Total</th>
                                @if ($isRecorded)
                                    <th scope="col">Rank</th>
                                @endif
                                <th>Model</th>
                                
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($contestants as $contestant)
                                <tr>
                                    <th>
                                        <span
                                            style="visibility: hidden">{{ $contestant->id }}</span>{{ $contestant->contestantNum }}.
                                        {{ $contestant->name }}
                                    </th>
                                    <td>
                                        @if ($contestant->suitability)
                                            {{ $contestant->suitability }}
                                        @else
                                            <input type="number" class="form-control w-75 suitability" id="suit{{$contestant->id}}"
                                                placeholder="Composure" min="1" max="50" name="suitability">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($contestant->projection)
                                            {{ $contestant->projection }}
                                        @else
                                            <input type="number" class="form-control w-75 swimwearProjection" id="pro{{$contestant->id}}"
                                                placeholder="Projection" min="1" max="50"
                                                name="swimwearProjection">
                                        @endif
                                    </td>
                                    <td class="{{$contestant->projection ? '':'swimwearTotal'}}">
                                        @if ($contestant->projection && $contestant->suitability)
                                            {{ $contestant->projection + $contestant->suitability }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    @if ($isRecorded)
                                        <td>
                                            {{ $contestant->rank }}
                                        </td>
                                    @endif
                                    <td>
                                        @include('facilitator.singleEvent.contestants.viewContestant')
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </form>

    
    <div class="modal fade" id="editrate" tabindex="-1"
     aria-labelledby="editrateLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">Enable edit</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal"
                     aria-label="Close"></button>
             </div>
             <div class="modal-body">
                     <input type="text" class="form-control" placeholder="Enter access code" id="inputedCode">
                     <div class="d-none" id="alertCode">
                        Incorrect access code
                     </div>
                    </div>
             <div class="modal-footer">
                 <button type="button" id="update" class="btn btn-primary btn btn-sm">Submit</button>
                 <button type="button"  class="btn btn-secondary btn btn-sm"
                     data-bs-dismiss="modal">Close</button>
                 
             </div>
         </div>
     </div>
 </div>
    <div id="editPage" class="d-none">
       @include('jcaJudges.pages.pre.editPages.swimwearEdit')
    </div>
@endsection


@section('judgingScript')
    <script type="module">
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let totalRate = [];

            $('input[type="number"]').on('input', function() {
                var value = parseInt($(this).val(), 10);
                if (value < 1) {
                    $(this).val(1);
                } else if (value > 50) {
                    $(this).val(50);
                }

                const row = $(this).closest('tr');
                const composure = parseInt(row.find('.suitability').val()) || 0;
                const projection = parseInt(row.find('.swimwearProjection').val()) || 0;
                const total = composure + projection;
                row.find('.swimwearTotal').text(total);

                totalRate = [];

                const rows = $('tbody tr');
                rows.each(function() {
                    const row = $(this);
                    const initTotal = row.find('.swimwearTotal').text();
                    let total = 0;

                    if (!isNaN(initTotal)) {
                        total = Number(initTotal);
                    }

                    if(total > 0){
                        totalRate.push(total);
                    }
                });

                const isMoreThan75 = totalRate.every(rate => rate > 75);
             
                if (isMoreThan75) {
                    $('#swimwearSubmitButton').prop('disabled', false);
                } else {
                    $('#swimwearSubmitButton').prop('disabled', true);
                }

            });

            $('#addSwimwear').submit(function(event) {
                event.preventDefault();
                const confirmSave = confirm('Are you sure to save ratings ?');
                if(!confirmSave) return;
                $('#swimwearSubmitButton').prop('disabled', true);
                const rows = $('tbody tr');
                const rowData = [];

            var url = $(this).attr("action");

            rows.each(function() {
                const row = $(this);
                const suitability = row.find('.suitability');
                const projectionInput = row.find('.swimwearProjection');

                // Check if there are input fields in the current row
                if (suitability.length > 0 && projectionInput.length > 0) {
                    const initTotal = row.find('.swimwearTotal').text();
                    let total = 0;

                    if (!isNaN(initTotal)) {
                        total = Number(initTotal);
                    }

                    const rowObj = {
                        contestantID: row.find('span').text().trim(),
                        suitability: suitability.val(),
                        projection: projectionInput.val(),
                        total
                    };

                    rowData.push(rowObj);
                }
            });

            const filteredData = rowData.filter(data => data.total > 0);
  
    if (filteredData.length > 0) {
        sendData(filteredData, url);
    }
});

            $('#update').click(function() {
                const accessCode = $('#accessCode').val();
                const inputedCode = $('#inputedCode').val();
                if(accessCode === inputedCode){

                    $('#addSwimwear').removeClass().addClass('d-none')
                    $('#editPage').removeClass()
                    $('#editrate').modal('hide');
                }else{
                    $('#alertCode').removeClass().addClass('alert alert-danger mt-2');
                }
            });
        });


        function sendData(data, url) {

            const formData = {
                data
            }
            processSend(formData)

            function processSend(formData) {
                $.post(url, formData)
                    .done(function(response) {
                        location.reload();
                    })
                    .fail(function(error) {
                        processSend(formData)
                    });
            }
        }
    </script>
@endsection
