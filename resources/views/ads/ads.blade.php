@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <h4 class="center">Ads</h4>
            <button class="btn btn-info ml-auto" id="createNewArea">Create Ads</button>
        </div>
    </div>
    <br>
    <table id="dataTable" style="width: 100%" class="table table-striped table-bordered">
        <thead class="bg-indigo-1 text-white">
        <tr>
            <th>Ads ID</th>
            <th>Image</th>
            <th width="280px">Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

{{-- create/update ads modal--}}
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="adsForm" name="adsForm" class="form-horizontal">
                    <input type="hidden" name="ads_id" id="ads_id">
                    <div class="form-group">
                        <label class="col-sm-12 control-label">Ads Image</label>
                        <div class="col-sm-12">
                            <label class="new-avatar hidden"><span class="far fa-plus-square"></span>
                                <input id="ads_image" name="ads_image" type="file" required="" class="text-center center-block file-upload"/>
                            </label>
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
            ajax: "{{ url('ads') }}",
            columns: [
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'id', name: 'id'},
                {   
                    data: 'ads_image', name: 'ads_image',
                    "render": function (data, type, full, meta) {
                        return "<a data-fancybox='' href='{{ URL('img/ads') }}/"+ full.ads_image +"'><img src='{{ URL('img/ads') }}/"+ full.ads_image +"' height='20'></a>";
                    },
                },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // create new ads
        $('#createNewArea').click(function () {
            $('#saveBtn').html("Create");
            $('#ads_id').val('');
            $('#adsForm').trigger("reset");
            $('#modelHeading').html("Create New Ads");
            $('#ajaxModel').modal('show');
        });

        // create or update ads
        $('#adsForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                data: $('#adsForm').serialize(),
                method:"POST",
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('#adsForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                    $('#saveBtn').html('Save');
                    // console.log(data)
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save');
                }
            });
        });

        // edit ads
        $('body').on('click', '.editArea', function () {
            var ads_id = $(this).data('id');
            $.get("{{ url('ads') }}" + '/' + ads_id + '/edit', function (data) {
                $('#modelHeading').html("Edit Ads");
                $('#saveBtn').html('Update');
                $('#ajaxModel').modal('show');
                $('#ads_id').val(data.id);
                $('#ads_name').val(data.ads_name);
                $('#ads_code').val(data.ads_code);
            })
        });

        // delete ads
        $('body').on('click', '.deleteArea', function () {
            var ads_id = $(this).data("id");
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
                        url: "{{ url('ads') }}" + '/' + ads_id,
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
