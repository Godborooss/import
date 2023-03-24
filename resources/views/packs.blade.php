@extends('layouts.app')
@section('content')


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">


    @if(session('error'))
        <div class="alert alert-dismissable alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>
                {!! session()->get('error') !!}
            </strong>
        </div>
        <p>

    @endif

<div class="" style="margin: 30px">
    <div class="card bg-light mt-3">

        <div class="card-body">
            <form action="{{ route('items.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Մուտքագրեք անվանում: </strong>
                        <label>
                            <input type="text" name="nameofpack" class="form-control" placeholder="projecti անուն">

                        </label> <button class="btn btn-success">Կատարել</button>
                    </div>
                </div>



            </form>
            <br>    <br>
{{--            <table class="table table-bordered mt-3">--}}
{{--                <tr>--}}
{{--                    <th colspan="3">--}}
{{--                        List Of Items--}}
{{--                        <a class="btn btn-warning float-end" href="{{ route('items.export') }}">Export Item Data</a>--}}
{{--                    </th>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <th>ID</th>--}}
{{--                    <th>Name</th>--}}
{{--                    <th>Show</th>--}}
{{--                </tr>--}}
{{--                @foreach($packs as $pack)--}}
{{--                    <tr>--}}
{{--                        <td>{{ $pack->id }}</td>--}}
{{--                        <td>{{ $pack->nameofpack }}</td>--}}
{{--                        <td>--}}
{{--                        <form  method="POST">--}}
{{--                            @csrf--}}
{{--                            <a class="btn btn-info" href="{{ route('packitems.show',$pack->id) }}">Show</a>--}}

{{--                        </form>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
{{--            </table>--}}



            <table class="table table-bordered mt-3">

                <tr>
                    <th>ID</th>
                    <th>Անուն</th>
                    <th>Show</th>
                    <th>export xml</th>

                </tr>

                @foreach($packs as $pack)
                    <tr>
                        <td>{{ $pack->id }}</td>
                        <td>{{ $pack->nameofpack }}</td>


                        <td>
                            <form method="POST">
                                @csrf
                                <a class="btn btn-info" href="{{ route('packitems.show',$pack->id) }}">Նայել</a>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="{{ route('create-xml', $pack->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">Ստեղծել XML</button>
                            </form>
                        </td>

                        <td>
                            <form method="POST" action="{{ route('packs.update', $pack->id) }}">
                        @csrf
                        @method('PUT')
                                @php
                                    $selectedReceiver = $pack->receiver ? $pack->receiver->id : null;
                                @endphp
                                <div style="display: inline-block;width: 15.1%; margin-right: 10px">
                                  <select name="receiver_id" class="form-select">

                                      @foreach($receivers as $receiver)
                                          <option value="{{ $receiver->id }}"{{ $selectedReceiver == $receiver->id ? ' selected' : '' }}>
                                              {{ $receiver->name }}
                                          </option>
                                      @endforeach

                                   </select>
                                </div>



                                <div style="display: inline-block;width: 10.5%;margin-right: 10px">
                            <select name="sender_id" class="form-select">

                                @php
                                    $selectedSender= $pack->sender ? $pack->sender->id : null;
                                @endphp



                                        @foreach($senders as $sender)
                                            <option value="{{ $sender->id }}"{{ $selectedSender == $sender->id ? ' selected' : '' }}>
                                                {{ $sender->name }}
                                            </option>
                                        @endforeach



                            </select>
                                </div>


                                <div style="display: inline-block;width: 10.5%;margin-right: 10px">
                            <select name="broker_id" class="form-select">
                                @php
                                    $selectedBroker= $pack->broker ? $pack->broker->id : null;
                                @endphp


                                @foreach($brokers as $broker)
                                    <option value="{{ $broker->id }}"{{ $selectedBroker == $broker->id ? ' selected' : '' }}>
                                        {{ $broker->name }}
                                    </option>
                                @endforeach
                            </select>
                                </div>


                                <div style="display: inline-block;width: 10.5%;margin-right: 10px">
                            <select name="method" class="form-select">

                                <option value="" selected disabled>{{$pack->method}} Method</option>
                                <option value="1">Method 1</option>
                                <option value="3">Method 3</option>
                                <option value="6">Method 6</option>
                            </select>
                                </div>

                            <div style="display: inline-block;width: 10.5%;margin-right: 10px">
                                <select name="currency" class="form-select">
                                    <option value="" selected disabled>{{$pack->currency}}  Currency</option>
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                </select>
                            </div>

                                <div style="display: inline-block;width: 10.5%; margin-right: 10px">
                                    <input style="" placeholder="Container num"  value="{{$pack->container}}" type="text" name="container" class="form-control">

                                </div>
                                <div style="display: inline-block;width: 10.5%; margin-right: 10px">
                                    <input  type="text" placeholder="Term" value="{{$pack->shipping_term}}" name="shipping_term" class="form-control">
                                </div>
                                <div style="display: inline-block;width: 10.5%; margin-right: 10px">
                                    <input  type="text"   placeholder="car_number   "  value="{{$pack->car_number}}" name="car_number" class="form-control">
                                </div>
                                <button style="margin-left: 6.8px" type="submit" class="btn btn-primary">Save</button>
                        </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="d-flex justify-content-end mt-4">
                {{ $packs->links('vendor.pagination.simple-tailwind') }}
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>

<!-- JavaScript code for the modal -->
{{--<script>--}}
{{--    $(document).ready(function () {--}}
{{--        // Show modal when button is clicked--}}
{{--        $('.create-company-button').click(function () {--}}
{{--            var packId = $(this).data('pack-id');--}}
{{--            $('#createCompanyModal-' + packId).modal('show');--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}

@endsection
