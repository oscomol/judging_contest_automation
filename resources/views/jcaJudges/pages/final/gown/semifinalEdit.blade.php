<form action="{{ route('semiScoreUpdate') }}" method="POST" id="editSwimwear">
        @csrf
        <div class="p-0">
            <div class="card">
                <div class="card-header">

                    <h3 class="card-title">Rating sheet
                        <span class="float-end">
                            <button type="submit" id="swimwearEditButton" class="btn btn-primary btn btn-sm">Update</button>
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
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($semiContestant as $contestant)
                                <tr>
                                    <th>
                                        <span
                                            style="visibility: hidden">{{ $contestant->id }}</span>{{ $contestant->contestantNum }}.
                                        {{ $contestant->name }}
                                    </th>
                                    <td>
                                        <input type="number" class="form-control w-75 beauty" placeholder="Beauty ...." value="{{$contestant->beauty}}"
                                                min="1" max="50" name="beauty[{{ $contestant->id }}]">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control w-75 semiPoise" value="{{$contestant->poise}}"
                                                placeholder="Poise grace ...." min="1" max="50"
                                                name="semiPoise[{{ $contestant->id }}]">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control w-75 semiProjection" value="{{$contestant->projection}}"
                                                placeholder="Projection ...." min="1" max="50"
                                                name="semiProjection[{{ $contestant->id }}]">
                                    </td>
                                    <td class="semiTotal">
                                        @if ($contestant->total > 0)
                                            {{ $contestant->total }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
    </form>

    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
      $('#editSwimwear').submit(function(event) {
        event.preventDefault();
        const confirmSave = confirm('Are you sure to save ratings ?');
        if(!confirmSave) return;
                $('#semiSubmitButton').prop('disabled', true);
                const rows = $('tbody tr');
                const rowData = [];
                var url = $(this).attr("action");

                rows.each(function() {
                    const row = $(this);
                    const beauty = row.find('.beauty');
                    const poise = row.find('.semiPoise');
                    const projection = row.find('.semiProjection');
                    const initTotal = row.find('.semiTotal').text();
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

                const filteredData = rowData.filter(data => data.total > 75 && data.beauty !== undefined);

                if(filteredData?.length){
                  sendData(filteredData, url);
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
