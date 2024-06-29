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
            <a class="nav-link" aria-current="page"href="{{ route('final.index') }}">Gown</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('semifinal.index') }}">Semifinal</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('finalJudge.index') ? 'active' : '' }}" aria-current="page" href="{{ route('finalJudge.index') }}">Final</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
@endsection

@section('judgesCont')
    <div id="show" class='d-none'>
        @include('jcaJudges.pages.final.gown.finaledit')
    </div>

<form action="{{ route('finalScore') }}" method="POST" id="addFinal">
    <div class="p-0">
        @if ($ranks->count() > 0)
            <h5 class="text-center">Respond recorded succesfully. Thank you for your participation!</h5>
        @endif
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Rating sheet
                    <span class="float-end">
                        @if ($ranks->count() > 0)
                        <button type="button" class="btn btn-primary btn btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editrate">
                            Update
                            </button>
                        @else
                        <button type="submit" id="finalCrowSubmitButton" class="btn btn-primary btn btn-sm"
                            disabled>Submit</button>
                        @endif
                        
                    </span>
                </h3>
            </div>

            <div class="card-body p-0">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Contestants</th>
                            <th scope="col">Beauty (50%)</th>
                            <th scope="col">Poise and projection (35%)</th>
                            <th scope="col">Projection (15%)</th>

                            @if ($ranks->count() < 1)
                                <th scope="col">Total</th>
                            @else
                                <th>Rank</th>
                            @endif

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contestants as $contestant)
                            <tr>
                                <th>
                                    <span
                                        style="visibility: hidden">{{ $contestant->id }}</span>{{ $contestant->contestantNum }}.
                                    {{ $contestant->name }}slmksm
                                </th>
                                <td>
                                    @if ($contestant->beauty)
                                        {{ $contestant->beauty }}
                                    @else
                                        <input type="number" class="form-control w-75 finalBeauty"
                                            placeholder="Beauty ...." min="1" max="50"
                                            name="finalBeauty[{{ $contestant->id }}]">
                                    @endif
                                </td>
                                <td>
                                    @if ($contestant->poise)
                                        {{ $contestant->poise }}
                                    @else
                                        <input type="number" class="form-control w-75 finalPoise"
                                            placeholder="Poise grace ...." min="1" max="50"
                                            name="finalPoise[{{ $contestant->id }}]">
                                    @endif
                                </td>
                                <td>
                                    @if ($contestant->projection)
                                        {{ $contestant->projection }}
                                    @else
                                        <input type="number" class="form-control w-75 finalProjection"
                                            placeholder="Projection ...." min="1" max="50"
                                            name="finalProjection[{{ $contestant->id }}]">
                                    @endif

                                </td>

                                @if ($ranks->count() < 1)
                                    <td class="finalTotal">
                                        @if ($contestant->total)
                                            {{ $contestant->total }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                @else
                                    <td>
                                        {{ $contestant->rank }}
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <form>



        <!-- Modal -->
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
  
@endsection

        @section('judgingScript')
            <script type="module">
                $(document).ready(function() {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('.finalBeauty').on('input', function() {
                        const row = $(this).closest('tr');
                        const beauty = parseInt(row.find('.finalBeauty').val()) || 0;
                        if (beauty < 1) {
                            $(this).val('');
                        } else if (beauty > 50) {
                            $(this).val(50);
                        }
                    });
                    $('.finalPoise').on('input', function() {
                        const row = $(this).closest('tr');
                        const beauty = parseInt(row.find('.finalPoise').val()) || 0;
                        if (beauty < 1) {
                            $(this).val('');
                        } else if (beauty > 35) {
                            $(this).val(35);
                        }
                    });
                    $('.finalProjection').on('input', function() {
                        const row = $(this).closest('tr');
                        const beauty = parseInt(row.find('.finalProjection').val()) || 0;
                        if (beauty < 1) {
                            $(this).val('');
                        } else if (beauty > 15) {
                            $(this).val(15);
                        }
                    });

                    $('.finalBeauty, .finalPoise, .finalProjection').on('input', function() {
                        const row = $(this).closest('tr');
                        const beauty = parseInt(row.find('.finalBeauty').val()) || 0;
                        const semiPoise = parseInt(row.find('.finalPoise').val()) || 0;
                        const semiProjection = parseInt(row.find('.finalProjection').val()) || 0;
                        const total = beauty + semiPoise + semiProjection;
                        row.find('.finalTotal').text(total);

                        let totalRate = [];

                        const rows = $('tbody tr');
                        rows.each(function() {
                            const row = $(this);
                            const initTotal = row.find('.finalTotal').text();
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
                            $('#finalCrowSubmitButton').prop('disabled', false);
                        } else {
                            $('#finalCrowSubmitButton').prop('disabled', true);
                        }
                    });


                    $('#addFinal').submit(function() {
                        event.preventDefault();
                       
                        const confirmSave = confirm('Are you sure to save ratings ?');
                        if(!confirmSave) return;
                        $('#finalCrowSubmitButton').prop('disabled', true);
                        const rows = $('tbody tr');
                        const rowData = [];
                        var url = $(this).attr("action");

                        rows.each(function() {
                            const row = $(this);
                            const beauty = row.find('.finalBeauty');
                            const poise = row.find('.finalPoise');
                            const projection = row.find('.finalProjection');
                            const initTotal = row.find('.finalTotal').text();
                            let total = 0;

                            if (!isNaN(initTotal)) {
                                total = Number(initTotal);
                            }

                            const rowObj = {
                                contestantID: row.find('span').text().trim(),
                                beauty: beauty.val(),
                                poise: poise.val(),
                                projection: projection.val(),
                                total
                            };

                            rowData.push(rowObj);
                        });

                        const filteredData = rowData.filter(data => data.projection !== undefined && data.total >= 75);

                        if (filteredData?.length) {
                            sendData(filteredData, url)
                        }

                    });

                    $('#update').click(function(){
                        const accessCode = $('#accessCode').val();
                        const inputedCode = $('#inputedCode').val();
                        if(accessCode === inputedCode){
                            $('#addFinal').removeClass().addClass('d-none')
                            $('#show').removeClass()
                            $('#editrate').modal('hide');
                        }else{
                            $('#alertCode').removeClass().addClass('alert alert-danger mt-2');
                        }
                    })
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
