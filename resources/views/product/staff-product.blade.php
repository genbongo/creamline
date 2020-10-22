@inject('variation','App\Variation')
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <h4 class="center">Product</h4>
        </div>
    </div>
    <br>
    <table id="dataTable" style="width: 100%" class="table table-striped table-bordered">
        <thead class="bg-indigo-1 text-white">
        <tr>
            <th>Product Image</th>
            <th>Product ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Sizes</th>
            <th>Flavors</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script type="text/javascript">

    //declare global variable
    var variation_data = [];

    $(function () {
        //ajax setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // datatable
        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('product_list') }}",
            columns: [
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {   
                    data: 'product_image', name: 'product_image',
                    "render": function (data, type, full, meta) {
                        return "<a data-fancybox='' href='{{ URL('img/product') }}/"+ data +"'><img src='{{ URL('img/product') }}/"+ data +"' height='20'></a>";
                    },
                },
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description'},
                {
                    data: 'size', name: 'size',
                    "render": function (data, type, full, meta) {
                        return data.slice(0, -1)
                    },
                },
                {
                    data: 'flavor', name: 'flavor',
                    "render": function (data, type, full, meta) {
                        return data.slice(0, -1)
                    },
                },
                // {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });

</script>
@endsection
