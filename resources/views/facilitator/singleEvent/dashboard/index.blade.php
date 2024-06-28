@extends('layout.eventLayout')

@section('eventContent')

<div class="d-flex flex-column align-items-center gap-2" id="loadingEventDash">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status"></div>
    <h5>Setting up dashboard. Please wait!</h5>
  </div>

  <div id="eventMain" class="d-none">

    <div class="w-100 px-3" >
      <div class="row">
        <div class="col-12 col-md-4 mb-4"> <!-- Adjusted column classes -->
            <div class="p-3 rounded bg-success bg-gradient d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="text-light fw-bold allEventCount">{{ $contestants->count() }}</h3>
                    <p class="text-light">Contestants</p>
                </div>
                <div>
                    <i class="fa fa-user" style="font-size: 60px; color: white; font-weight: bold;"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4 mb-4"> <!-- Adjusted column classes -->
            <div class="p-3 rounded bg-warning bg-gradient d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="text-light fw-bold preJudges">0</h3>
                    <p class="text-light">Preliminary</p>
                </div>
                <div>
                    <i class="fa fa-users" style="font-size: 60px; color: white; font-weight: bold;"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4 mb-4"> <!-- Adjusted column classes -->
            <div class="p-3 rounded bg-danger bg-gradient d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="text-light fw-bold finJudges">0</h3>
                    <p class="text-light">Final judges</p>
                </div>
                <div>
                    <i class="fa fa-users" style="font-size: 60px; color: white; font-weight: bold;"></i>
                </div>
            </div>
        </div>
      </div>
    </div>

    <div class="px-3">
   
        <div class="card w-100">
            <div class="card-body px-3 pt-3">
                <h5 class="card-title">Contestants list</h5>
                @if ($contestants->count() > 0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Address</th>
                                <th>Age</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contestants as $contestant)
                                <tr>
                                    <th>{{ $contestant->contestantNum }}. {{ $contestant->name }}</th>
                                    <td>{{ $contestant->address }}</td>
                                    <td>{{ $contestant->age }}</td>
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
    
        <div class="card w-100 mt-4">
            <div class="card-body px-3 pt-3">
                    <h5 class="card-title">Judegs list</h5>
                 <table class="d-none" id="hasJudges">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Access code</th>
                        </tr>
                    </thead>
                    <tbody id="singleEventJudges">
                    </tbody>
                </table>
    
    
                <div class="w-100 d-flex flex-column align-items-center mt-4 gap-2" id="noJudges">
                    <li class="fa fa-users" style="font-size: 80px; font-weight: bold; color: gray;"></li>
                    <h5>No judges added</h5>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection


@section('mainScript')
    <script type="module">
         $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const eventID = window.location.pathname.split('/')[2];

            $.ajax({
                url: '/judges/get?event=' +eventID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#loadingEventDash').removeClass().addClass('d-none');
                    $('#eventMain').removeClass().addClass('row my-4');
                   const {judges} = data;
                   if(judges?.length){
                    const preliminary = judges.filter(judge => judge.category === 'Preliminary');
                    const final = judges.filter(judge => judge.category === 'Final');
                    $('.preJudges').text(preliminary?.length)
                    $('.finJudges').text(final?.length)
                    $('#noJudges').removeClass().addClass('d-none');
                    $('#hasJudges').removeClass().addClass('table table-bordered');
                    let singleEventJudges = '';
                    for(let x=0; x<judges.length; x++){
                        const judge = judges[x];
                        singleEventJudges += `
                        <tr>
                            <td>${judge.name}</td>
                            <td>${judge.category}</td>
                            <td>${judge.accessCode}</td>
                        </tr>
                        `
                    }
                    $("#singleEventJudges").html(singleEventJudges);
                   }else{
                    // do something
                   }
                  
                }
            });
        });
    </script>
@endsection