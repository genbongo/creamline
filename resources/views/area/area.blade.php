@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <h4 class="center">Area</h4>
            <button class="btn btn-info ml-auto" id="createNewArea">Create Area</button>
        </div>
    </div>
    <br>
    <table id="dataTable" class="table table-striped table-bordered">
        <thead class="bg-indigo-1 text-white">
        <tr>
            <th>Area ID</th>
            <th>Name</th>
            <th>Code</th>
            <th width="280px">Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

{{-- create/update area modal--}}
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="areaForm" name="areaForm" class="form-horizontal">
                    <input type="hidden" name="area_id" id="area_id">
                    <div class="form-group">
                        <label for="area_name" class="col-sm-12 control-label">Area Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="area_name" name="area_name" placeholder="Enter Area name"
                                   value="" maxlength="50" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12 control-label">Area Code</label>
                        <div class="col-sm-12">
                            <input for="area_code" type="number" class="form-control" id="area_code" name="area_code"
                                   placeholder="Enter Area Code"
                                   value="" maxlength="50" required="" autocomplete="off">
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
            ajax: "{{ url('area') }}",
            columns: [
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'id', name: 'id'},
                {data: 'area_name', name: 'area_name'},
                {data: 'area_code', name: 'area_code'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // create new area
        $('#createNewArea').click(function () {
            $('#saveBtn').html("Create");
            $('#area_id').val('');
            $('#areaForm').trigger("reset");
            $('#modelHeading').html("Create New Area");
            $('#ajaxModel').modal('show');
        });

        // create or update area
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Saving..');

            $.ajax({
                data: $('#areaForm').serialize(),
                url: "{{ url('area') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#areaForm').trigger("reset");
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

        // edit area
        $('body').on('click', '.editArea', function () {
            var area_id = $(this).data('id');
            $.get("{{ url('area') }}" + '/' + area_id + '/edit', function (data) {
                $('#modelHeading').html("Edit Area");
                $('#saveBtn').html('Update');
                $('#ajaxModel').modal('show');
                $('#area_id').val(data.id);
                $('#area_name').val(data.area_name);
                $('#area_code').val(data.area_code);
            })
        });

        // delete area
        $('body').on('click', '.deleteArea', function () {
            var area_id = $(this).data("id");
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
                        url: "{{ url('area') }}" + '/' + area_id,
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
