@inject('areas','App\Area')
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <h4 class="center">Store</h4>
            <button class="btn btn-info ml-auto" id="createNewStore">Create Store</button>
        </div>
    </div>
    <br>
    <table id="dataTable" class="table table-striped table-bordered">
        <thead class="bg-indigo-1 text-white">
        <tr>
            <th>Store ID</th>
            <th>Store Name</th>
            <th>Store Address</th>
            <th>Area</th>
            <th width="280px">Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

{{-- create/update store modal--}}
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="storeForm" name="storeForm" class="form-horizontal">
                    <input type="hidden" name="store_id" id="store_id">
                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                    <div class="form-group">
                        <label for="store_name" class="col-sm-12 control-label">Store Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="store_name" name="store_name" placeholder="Enter Store Name"
                                   value="" maxlength="50" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12 control-label">Store Address</label>
                        <div class="col-sm-12">
                            <input for="store_address" type="text" class="form-control" id="store_address" name="store_address"
                                   placeholder="Enter Store Address"
                                   value="" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="area_id" class="col-md-12 col-form-label">Designated Location:</label>

                        <div class="col-md-12">
                            <select class="form-control" id="area_id" name="area_id">
                                @foreach($areas->all() as $area)
                                  <option value="{{ $area->id }}">{{ $area->area_name." : ".$area->area_code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-offset-12 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

<script type="text/javascript">
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
            ajax: "{{ url('store') }}",
            columns: [
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'id', name: 'id'},
                {data: 'store_name', name: 'store_name'},
                {data: 'store_address', name: 'store_address'},
                {data: 'area_id', name: 'area_id'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // create new store
        $('#createNewStore').click(function () {
            $('#saveBtn').html("Create");
            $('#store_id').val('');
            $('#storeForm').trigger("reset");
            $('#modelHeading').html("Create New Store");
            $('#ajaxModel').modal('show');
        });

        // create or update store
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Saving..');

            $.ajax({
                data: $('#storeForm').serialize(),
                url: "{{ url('store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#storeForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                    $('#saveBtn').html('Save');
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save');
                }
            });
        });

        // edit store
        $('body').on('click', '.editStore', function () {
            var store_id = $(this).data('id');
            $.get("{{ url('store') }}" + '/' + store_id + '/edit', function (data) {
                $('#modelHeading').html("Edit Store");
                $('#saveBtn').html('Update');
                $('#ajaxModel').modal('show');
                $('#store_id').val(data.id);
                $('#store_name').val(data.store_name);
                $('#store_address').val(data.store_address);
            })
        });

        // delete store
        $('body').on('click', '.deleteStore', function () {
            var store_id = $(this).data("id");
            var stat = $(this).data("stat");

            var swal_text = '';

            if(stat == 0){
                swal_text = 'Once deleted, you will not be able to retreive this!';
            }else{
                swal_text = 'Once activated, you will be able to retreive this!';
            }

            swal({
                title: "Are you sure?",
                text: swal_text,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((isTrue) => {
                if (isTrue) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('store') }}" + '/' + store_id,
                        success: function (data) {
                            table.draw();
                            swal(data.message, {
                                icon: "success",
                            });
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });
        });

    });
</script>
@endsection
