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

        <a class="btn btn-success" href="javascript:void(0)" id="createNewBroker">Ստեղծել Բրոկեր</a>
        <table class="table table-bordered data-table">
            <thead>
            <tr>
                <th>No</th>
                <th>Անուն</th>
                <th>ՀՎՀՀ</th>
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
                    <form id="brokerForm" name="brokerForm" class="form-horizontal">
                        <input type="hidden" name="broker_id" id="broker_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Մուտքագրել անունը" value="" maxlength="50" required="">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="hvhh" class="col-sm-2 control-label">hvhh</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="hvhh" name="hvhh" placeholder="Մուտքագրել ՀՎՀՀ" value="" maxlength="50" required="">
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
                ajax: "{{ route('brokers.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'hvhh', name: 'hvhh'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Button
            --------------------------------------------
            --------------------------------------------*/
            $('#createNewBroker').click(function () {
                $('#saveBtn').val("create-broker");
                $('#broker_id').val('');
                $('#brokerForm').trigger("reset");
                $('#modelHeading').html("Ստեղծել բրոկեր");
                $('#ajaxModel').modal('show');
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.editBroker', function () {
                var broker_id = $(this).data('id');
                $.get("{{ route('brokers.index') }}" +'/' + broker_id +'/edit', function (data) {
                    $('#modelHeading').html("Խմբավորել Բրոկեր");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#broker_id').val(data.id);
                    $('#name').val(data.name);
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
                    data: $('#brokerForm').serialize(),
                    url: "{{ route('brokers.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {

                        $('#brokerForm').trigger("reset");
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
            $('body').on('click', '.deleteBroker', function () {

                var broker_id = $(this).data("id");
                confirm("Are You sure want to delete !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('brokers.store') }}"+'/'+broker_id,
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
