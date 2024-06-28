@extends('layout.eventLayout')

@section('eventContent')

<div class="d-flex flex-column align-items-center gap-2" id="loading">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status"></div>
    <h5>Getting data. Please wait!</h5>
</div>


    <form action="{{ url('/semiContestantAdd', ['event' => $event->id]) }}" method="POST" id="addSemiContestant" class="d-none">
        @csrf
        <div class="card">
            <div class="d-flex justify-content-between align-items-center customTableHeader">
                <h3 class="card-title mr-4">Tabulation</h3>
                <div class="d-flex gap-2">
                    <input type="number" class="form-control form-control-sm" id="topContestant" placeholder="Semi contestant" >
                    <button type="submit" class="btn btn-primary btn-sm ml-3" id="submitSemiCont">Submit</button>
                </div>
            </div>

            <div class="card-body p-0">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Preliminary</th>
                            <th>Swimwear</th>
                            <th>Gown </th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>Contestant</th>
                            <th>Rank</th>
                            <th>Rank</th>
                            <th>Rank</th>
                            <th>Total Rank</th>
                            <th>Overall Rank</th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                    </tbody>
                </table>
            </div>
        </div>
    </form>
@endsection

@section('mainScript')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            const eventID = window.location.pathname.split('/')[3];

            let contestantList = [];

            $.ajax({
                url: '/getRanking/get?event=' + eventID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                   setTimeout(() => {
                    $('#loading').removeClass().addClass('d-none');
                    $('#addSemiContestant').removeClass().addClass('');
                   }, 1000);
                    const contestants = data.contestants;
                    contestantList = contestants;
                    const isAtSemi = contestantList.filter(con => con.class !== "");

                    if (isAtSemi?.length) {
                        $('#submitSemiCont').prop('disabled', true);
                        $('#topContestant').prop('readonly', true);
                        $('#topContestant').prop('type', 'text');
                        $('#topContestant').val('Top ' + isAtSemi.length);
                    }


                    displayCont(contestantList);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });

            $('#topContestant').change(function(){
                const semi = $(this).val();  
                if(semi >= contestantList?.length){
                    $(this).val(contestantList?.length);
                }else{
                    if(semi < 1){
                        $(this).val('');
                    }
                }
                contestantList = contestantList.map(con => {
                    if(con.overallRank <= semi){
                        con.class = 'bg-warning';
                    }else{
                        con.class = '';
                    }
                    return con;
                });
                displayCont(contestantList);
            })

            $('#addSemiContestant').submit(function(event) {
                event.preventDefault();

                const semi = $('#topContestant').val();

                var url = $(this).attr("action");

                const topContestant = contestantList.filter(con => con.overallRank <= semi);

                if(topContestant?.length){
                    let data = [];
                    topContestant.forEach(elem => {
                        data.push({contestantID: elem.id * 1, rank: elem.overallRank * 1, eventID: elem.eventID * 1, category: 'semi'});
                    })

                    $.post(url, {data})

                    .done(function(response) {
                       location.reload();
                    })
                    .fail(function(error) {
                       console.log(error)
                    });
                }
            });

            function displayCont(contestants){
                let contestantRes = '';
                contestants.forEach(function(con) {
                    contestantRes += `
                        <tr>
                            <td>${con.contestantNum}. ${con.name}</td>
                            <td>${con.preliminaryRank}</td>
                            <td>${con.swimwearRank}</td>
                            <td>${con.gownRank}</td>
                            <td>${con.total}</td>
                            <td>${con.overallRank}${con.class ? '<li class="fa fa-user"></li>' : ''}</td>
                        </tr>
                    `;
                });
                $('.tbody').html(contestantRes);
            }
        });
    </script>
@endsection

<style>
    .customTableHeader {
        border-bottom: 1px solid lightgray;
        padding: 10px;
    }

    #topContestant {
        width: 180px;
    }
</style>
