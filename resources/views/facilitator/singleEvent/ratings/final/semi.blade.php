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


    <form method="POST" action="{{ url('/semiContestantAdd', [
        'event' => $event->id,
    ]) }}"  id="addFinalContestnt" class="d-none">
        <div class="card">
            <div class="d-flex justify-content-between align-items-center customTableHeader px-2 pt-2">
                <h3 class="card-title">Tabulation</h3>
                <div class="d-flex gap-2">
                    <input type="number" class="form-control form-control-sm" id="semiContestant"
                        placeholder="Semi contestant">
                    <button type="submit" class="btn btn-primary btn btn-sm ml-3" id="submitFinalCont" disabled>Submit</button>
                    <button type="button" class="btn btn-sm btn btn-secondary" id="print">Print</button>
                </div>
            </div>

            <div class="card-body p-0">
                <table class="table table-sm table-bordered" id="myTable">
                    <thead>
                        <tr class="judges">
                            <th></th>
                        </tr>
                    </thead>

                    <tbody class="tbody">
                        <tr class="totalRow">
                            <th style="width: 240px">Contestant</th>
                        </tr>

                    </tbody>

                </table>
            </div>

        </div>
    </form>
@endsection


@section('mainScript')
    <script type="module">
        $(document).ready(function() {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let contestantList = [];

            const eventID = window.location.pathname.split('/')[3];
            $.ajax({
                url: '/getSemi/get?event=' + eventID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    $('#loading').removeClass().addClass('d-none');
                    $('#addFinalContestnt').removeClass().addClass('mt-3');

                    const contestants = data.contestants;
                    const judges = data.judges;
                    contestantList = contestants;

                    const atFnal = contestantList.filter(con => con.class !== "");

                    if (atFnal?.length) {
                        $('#submitFinalCont').prop('disabled', true);
                        $('#semiContestant').prop('readonly', true);
                        $('#semiContestant').prop('type', 'text');
                        $('#semiContestant').val('Top ' + atFnal.length);
                    }

                    displayJudges(judges);
                    displayResult(contestants);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    // Handle error if needed
                }
            });

            $('#semiContestant').change(function(){
                const semi = $(this).val();  

                if(semi > 0){
                    $('#submitFinalCont').prop('disabled', false)
                }else{
                    $('#submitFinalCont').prop('disabled', true)
                }

                if(semi >= contestantList?.length){
                    $(this).val(contestantList?.length);
                }else{
                    if(semi < 1){
                        $(this).val('');
                    }
                }
                contestantList = contestantList.map(con => {
                    if(con.rank <= semi){
                        con.class = 'bg-warning';
                    }else{
                        con.class = '';
                    }
                    return con;
                });
                displayResult(contestantList);
            })

            $('#addFinalContestnt').submit(function(event) {
                event.preventDefault();

                const semi = $('#semiContestant').val();

                var url = $(this).attr("action");

                const semiContestant = contestantList.filter(con => con.rank <= semi);

                if(semiContestant?.length){
                    let data = [];
                    semiContestant.forEach(elem => {
                        data.push({contestantID: elem.id * 1, rank: elem.rank * 1, eventID: elem.eventID * 1, category: 'final'});
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
            
        });

        function displayJudges(judges) {
            let judgesHtml = '';
            let totalRow = '';
            for (let i = 0; i < judges.length; i++) {
                const judge = judges[i];
                judgesHtml += `<th>${judge.name}</th>`;
                totalRow += `<th>Total</th>`;
            }
            $('.judges').append(judgesHtml);
            $('.totalRow').append(totalRow);
            $('.totalRow').append('<th>Total</th>');
            $('.totalRow').append('<th>Rank</th>');
        }

        function displayResult(contestants) {

            let contestantsHtml = '';
            for (let x = 0; x < contestants.length; x++) {
                const contestant = contestants[x];
                let totalHtml = '';
                for (let y = 0; y < contestant.totalRating.length; y++) {
                    totalHtml += `<th>${contestant.totalRating[y]}</th>`;
                }
                contestantsHtml += `
                    <tr style="background: red;">
                        <th>${contestant.contestantNum}. ${contestant.name}</th>
                        ${totalHtml}
                        <th>${contestant.total}</th>
                        <th>${contestant.rank}${contestant.class ? '<li class="fa fa-user"></li>' : ''}</th>
                    </tr>
                `;
            }
            $('.tbody').html(contestantsHtml);
        }
    </script>
@endsection

<style>
    .bg{
        background: red;
    }
    </style>