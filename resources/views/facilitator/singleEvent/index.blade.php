@extends('layout.eventLayout')

@section('eventContent')
    <div class="w-100 p-2">
        @include('facilitator.singleEvent.judges.byCategory.preliminary')
        @include('facilitator.singleEvent.judges.byCategory.final')
    </div>
@endsection

@section('mainScript')
    <script type="module">
        $(document).ready(function() {

            $(".addJudgesForm").submit(function(){
                $(this).find('button[type="submit"]').prop('disabled', true);
                $(this).find('button[type="submit"]').find('.spinner-border').removeClass('d-none');
                $(this).find('span:nth-child(2)').text("Submitting...");
            });

            $(".adminDelete").submit(function(){
                $(this).find('button[type="submit"]').prop('disabled', true);
                $(this).find('button[type="submit"]').find('.spinner-border').removeClass('d-none');
                $(this).find('span:nth-child(2)').text("Deleting...");
            });

            $(".editJudge").submit(function(){
                $(this).find('button[type="submit"]').prop('disabled', true);
                $(this).find('button[type="submit"]').find('.spinner-border').removeClass('d-none');
                $(this).find('span:nth-child(2)').text("Updating...");
            });
           

            $('.eventJudges').click(function() {
                const accessCode = $(this).attr('code');
                const eventId = $(this).attr('eventId');
                const category = $(this).attr('category');

                const baseURL = `${window.location.protocol}//${window.location.host}`;
                const accessLink =
                    `${baseURL}/jca/judges/event=${eventId}/category=${category}/accessCode=${accessCode}`;

                navigator.clipboard.writeText(accessLink)
                    .then(() => {
                        console.log('Link copied to clipboard:', accessLink);
                    })
                    .catch(err => {
                        console.error('Failed to copy link to clipboard:', err);
                    });

                $("#copy-"+accessCode).removeClass().addClass("btn btn-outline-success btn btn-sm");
                $("#copyBtn-"+accessCode).removeClass().addClass("d-none");
                setTimeout(() => {
                    $("#copy-"+accessCode).removeClass().addClass("d-none");
                    $("#copyBtn-"+accessCode).removeClass().addClass("btn btn-outline-secondary btn btn-sm eventJudges");
                }, 2000);

            })
        });
    </script>
@endsection

