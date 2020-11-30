@inject('areas','App\Area')
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <h4 class="center">{{ $client->fname . " ". $client->lname  }}</h4>
            <button class="btn btn-info ml-auto" id="createNewClient">Create Client</button>
        </div>
    </div>
    <br>
    <table id="dataTable" class="table table-striped table-bordered">
        <thead class="bg-indigo-1 text-white">
        <tr>
            <th>Store ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Area</th>
            <th>Status</th>
            <th width="280px">Action</th>
        </tr>   
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

{{-- create/update client modal--}}
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="clientForm" name="clientForm" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="client_id" id="client_id">
                            <input type="hidden" name="action" id="action">
                            <div class="form-group">
                                <label for="fname" class="col-sm-12 control-label">First Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter First Name"
                                           value="" maxlength="50" required="" autocomplete="off" onkeypress="return onlyLetters(event)">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mname" class="col-sm-12 control-label">Middle Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="mname" name="mname" placeholder="Enter Middle Name"
                                           value="" maxlength="50" required="" autocomplete="off" onkeypress="return onlyLetters(event)">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lname" class="col-sm-12 control-label">Last Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Last Name"
                                           value="" maxlength="50" required="" autocomplete="off" onkeypress="return onlyLetters(event)">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label" for="email">Email</label>
                                <div class="col-sm-12">
                                    <input type="email" class="form-control" id="email" name="email"
                                           placeholder="Enter Email"
                                           value="" maxlength="50" required="" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contact_num" class="col-sm-12 control-label">Contact Number</label>
                                <div class="col-sm-12">
                                    <input type="number" class="form-control" id="contact_num" name="contact_num" placeholder="Enter Contact"
                                           value="" required="" autocomplete="off" onkeypress="return onlyNumbers(event)">
                                </div>
                            </div>
                            <div class="form-group" id="div_password">
                                <label class="col-sm-12 control-label" for="password">Generated Password</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="password" name="password"
                                           placeholder="Enter Password"
                                           value="" maxlength="50" required="" autocomplete="off">
                                </div>
                            </div>
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
            ajax: "{{ url('client/3/stores') }}",
            columns: [
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'id', name: 'id'},
                {data: 'store_name', name: 'store_name'},
                {data: 'store_address', name: 'store_address'},
                {data: 'area', name: 'area'},
                {
                    data: 'is_deleted', name: 'is_deleted',
                    "render": function (data, type, full, meta) {
                        var output = '';
                        if(!full.is_deleted){
                            output = '<span class="text-success font-weight-bold">Active</span>';
                        }else{
                            output = '<span class="text-danger font-weight-bold"">In-Active</span>';
                        }

                        return output;
                    },
                },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // deacttivate store
         $('body').on('click', '.deactivate', function () {
            var store_id = $(this).data("id");

            var swal_text = 'Are you sure you want to deactivate the store?';

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

        // deacttivate store
        $('body').on('click', '.activate', function () {
            var store_id = $(this).data("id");

            var swal_text = 'Are you sure you want to activate the store?';

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
