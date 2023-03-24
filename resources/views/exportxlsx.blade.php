@extends('layouts.app')
@section('content')

    <head>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

            <!-- Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Import and Export XML Data</title>
        <style>
            .body {
                font-family: Arial, sans-serif;
                font-size: 14px;
                margin: 0;
                padding: 0;
            }
            .containere {
                margin: 20px auto;
                padding: 20px;
                max-width: 600px;
                border: 1px solid #ccc;
            }
            .btne {
                display: inline-block;
                padding: 10px 20px;
                background-color: #4CAF50;
                color: #fff;
                font-size: 16px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            .btne:hover {
                background-color: #3e8e41;
            }
            .table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            .th, .td {
                text-align: left;
                padding: 8px;
                border-bottom: 1px solid #ddd;
            }
            .th {
                background-color: #4CAF50;
                color: #fff;
            }
            .action-btne {
                background-color: #008CBA;
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            .action-btne:hover {
                background-color: #006f8c;
            }
        </style>
    </head>


    <div class="body">
        <div style="
                margin: 20px auto;
                padding: 20px;
                max-width:1200px;
                border: 1px solid #ccc;
            ">

            <form method="post" action="{{ route('xmlimport.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group" style="padding-right: 300px">
                    <label for="xmlFile">Выберите файл XML:</label>

                    <input  type="file" name="xmlFile" id="xmlFile" class="form-control">
                </div>
                <button type="submit" style="margin-top: 15px" class="btn btn-primary">Импортировать</button>
            </form>
            <table class="table">
                <thead>
                <tr>
                    <th class="th" style="text-align: center"   >ID</th>
                    <th class="th" style="text-align: center">Organization Name</th>
                    <th class="th" style="text-align: center">Created At</th>
                    <th class="th" style="text-align: center">Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($xmlpacks as $xmlpack)

                    <tr>
                        <td style="text-align: center">{{$xmlpack->id}}</td>
                        <td style="text-align: center">{{$xmlpack->exporter}}</td>
                        <td style="text-align: center">{{$xmlpack->created_at}}</td>
                        <td style="text-align: center">
                            <button style=" background-color: #d5dcde;color: #fff;border: none;border-radius: 5px;cursor: pointer;">
                                <a href="{{ route('exportxml', ['id' => $xmlpack]) }}" style="text-decoration: none;">Экспортировать в Excel</a>
                        </button>
                        </td>

                    </tr>
                @endforeach

                </tbody>

            </table>
            <div class="d-flex justify-content-end mt-4">
                {{ $xmlpacks->links('vendor.pagination.simple-tailwind') }}
            </div>
        </div>

    </div>

@endsection
