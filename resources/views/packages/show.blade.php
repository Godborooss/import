<!DOCTYPE html>
<html lang="en">
<head>


    <title>s</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />


</head>


<body>

<div class="container">
    <div class="card bg-light mt-3">

        <div class="card-body">
            <form method="POST" action="{{ route('items.update') }}">
                @csrf

            <table class="table table-bordered mt-3">

                <tr>

                    <th >
                        <button type="submit" class="btn btn-primary">Պահպանել</button>

                    </th>

                </tr>
                <tr>
                    <th>ID</th>
                    <th>Անուն</th>
                    <th>Քանակ</th>
                    <th>Գին</th>
                    <th>Նետտո</th>
                    <th>Բրուտո</th>
                    <th>Տեղերի քանակ</th>
                    <th>Երկիր</th>
                    <th>Որոնում</th>
                </tr>
                @php($count=1)
                @foreach($items as $item)
                    @if($item->pack_id == $pack->id )
                        <tr>
                            <td>{{$count++ }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->netto }}</td>
                            <td>{{ $item->brutto }}</td>
                            <td>{{ $item->package }}</td>
                            <td>{{ $item->country }}</td>

                            <td>
                                <div class="position-relative">
                                    <input type="text" name="nameofproducts[{{ $item->id }}]" value="{{ $item->nameofproduct }}" class="form-control typeahead search" id="search_{{ $item->id }}">

                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach



            </table>
            </form>

        </div>
    </div>
</div>
<script type="text/javascript">


var path = "{{ route('autocomplete') }}";

$('.search').typeahead({
    source: function (query, process) {
        return $.get(path, {
            query: query
        }, function (data) {
            return process(data);
        });
    }
});
</script>
{{--<script>var path = "{{ route('autocomplete') }}";--}}

{{--    $('.search').typeahead({--}}
{{--        source: function (query, process) {--}}
{{--            return $.get(path, {--}}
{{--                query: query--}}
{{--            }, function (data) {--}}
{{--                var $input = $('.search');--}}
{{--                var $resultsContainer = $input.parent().find('.autocomplete-results');--}}
{{--                $resultsContainer.empty();--}}
{{--                $.each(data, function(i, item) {--}}
{{--                    var $result = $('<div>').addClass('result').text(item);--}}
{{--                    $resultsContainer.append($result);--}}
{{--                });--}}
{{--                return process(data);--}}
{{--            });--}}
{{--        }--}}
{{--    });--}}

{{--    $(document).on('click', '.result', function () {--}}
{{--        var value = $(this).text();--}}
{{--        $(this).closest('.position-relative').find('.search').val(value);--}}
{{--        $(this).closest('.autocomplete-results').empty();--}}
{{--    });</script>--}}
</body>
</html>




