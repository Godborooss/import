@extends('layouts.app')
@section('content')

    <title>Laravel Ajax CRUD Tutorial Example - ItSolutionStuff.com</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


    <div class="container">

        <a class="btn btn-success" href="javascript:void(0)" id="createNewSender"> Ստեղծել ուղղարկող ընկերություն </a>
        <table class="table table-bordered data-table">
            <thead>
            <tr>
                <th>No</th>
                <th>Ուղղարկող ընկերության անվանումը</th>
                <th>Հասցե</th>
                <th>Քաղաք</th>
                <th>Երկիր</th>
                <th width="280px">Գործողություն</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="senderForm" name="senderForm" class="form-horizontal">
                        <input type="hidden" name="sender_id" id="sender_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Անուն</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Արտահանող ընկերության անունը անգլերեն " value="" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-2 control-label">Հասցե</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="address" name="address" placeholder="Մուտքագրեք հասցեն" value="" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city" class="col-sm-2 control-label">Քաղաք</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="city" name="city" placeholder="Մուտքագրեք քաղաքը" value="" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="country" class="col-sm-2 control-label">Երկիր</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="country" name="country" placeholder="Մուտքագրեք երկիրը" value="" maxlength="50" required="">
                            </div>
                        </div>


                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Պահպանել
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script type="text/javascript">
        $(function () {

            /*------------------------------------------
             --------------------------------------------
             Pass Header Token
             --------------------------------------------
             --------------------------------------------*/
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /*------------------------------------------
            --------------------------------------------
            Render DataTable
            --------------------------------------------
            --------------------------------------------*/
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('senders.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'address', name: 'address'},
                    {data: 'city', name: 'city'},
                    {data: 'country', name: 'country'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Button
            --------------------------------------------
            --------------------------------------------*/
            $('#createNewSender').click(function () {
                $('#saveBtn').val("create-sender");
                $('#sender_id').val('');
                $('#senderForm').trigger("reset");
                $('#modelHeading').html("Ստեղծել ուղղարկող ընկերություն");
                $('#ajaxModel').modal('show');
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.editSender', function () {
                var sender_id = $(this).data('id');
                $.get("{{ route('senders.index') }}" +'/' + sender_id +'/edit', function (data) {
                    $('#modelHeading').html("Edit Sender");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#sender_id').val(data.id);
                    $('#name').val(data.name);
                    $('#address').val(data.address);
                    $('#city').val(data.city);
                    $('#country').val(data.country);


                })
            });

            /*------------------------------------------
            --------------------------------------------
            Create Receiver Code
            --------------------------------------------
            --------------------------------------------*/
            $('#saveBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    data: $('#senderForm').serialize(),
                    url: "{{ route('senders.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {

                        $('#senderForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();

                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });

            /*------------------------------------------
            --------------------------------------------
            Delete Receiver  Code
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.deleteSender', function () {

                var sender_id = $(this).data("id");
                confirm("Are You sure want to delete !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('senders.store') }}"+'/'+sender_id,
                    success: function (data) {
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });

        });
    </script>

@endsection
