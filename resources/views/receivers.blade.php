@extends('layouts.app')
@section('content')


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

    <a class="btn btn-success" href="javascript:void(0)" id="createNewReceiver"> Ստեղծել ներմուծող ընկերություն </a>
    <table class="table table-bordered data-table">
        <thead>
        <tr>
            <th>No</th>
            <th>Ընկերության անվանումը</th>
            <th>Հասցե</th>
            <th>Հարկային կոդ ՀՎՀՀ</th>
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
                <form id="receiverForm" name="receiverForm" class="form-horizontal">
                    <input type="hidden" name="receiver_id" id="receiver_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Անուն</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Ներմուծող ընկերության անվանումը անգլերեն" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label">Հասցե</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="address" name="address" placeholder="Մուտքագրեք հասցեն" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hvhh" class="col-sm-2 control-label">ՀՎՀՀ</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="hvhh" name="hvhh" placeholder="Մուտքագրեք ՀՎՀՀ" value="" maxlength="50" required="">
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
            ajax: "{{ route('receivers.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'address', name: 'address'},
                {data: 'hvhh', name: 'hvhh'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        /*------------------------------------------
        --------------------------------------------
        Click to Button
        --------------------------------------------
        --------------------------------------------*/
        $('#createNewReceiver').click(function () {
            $('#saveBtn').val("create-receiver");
            $('#receiver_id').val('');
            $('#receiverForm').trigger("reset");
            $('#modelHeading').html("Ստեղծել ներմուծող ընկերություն");
            $('#ajaxModel').modal('show');
        });

        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.editReceiver', function () {
            var receiver_id = $(this).data('id');
            $.get("{{ route('receivers.index') }}" +'/' + receiver_id +'/edit', function (data) {
                $('#modelHeading').html("Խմբավորել ներմուծող ընկերություն");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#receiver_id').val(data.id);
                $('#name').val(data.name);
                $('#address').val(data.address);
                $('#hvhh').val(data.hvhh);
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
                data: $('#receiverForm').serialize(),
                url: "{{ route('receivers.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {

                    $('#receiverForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();

                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Պահպանել');
                }
            });
        });

        /*------------------------------------------
        --------------------------------------------
        Delete Receiver  Code
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.deleteReceiver', function () {

            var receiver_id = $(this).data("id");
            confirm("Are You sure want to delete !");

            $.ajax({
                type: "DELETE",
                url: "{{ route('receivers.store') }}"+'/'+receiver_id,
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
