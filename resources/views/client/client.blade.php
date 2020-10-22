@inject('areas','App\Area')
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <h4 class="center">Client</h4>
            <button class="btn btn-info ml-auto" id="createNewClient">Create Client</button>
        </div>
    </div>
    <br>
    <table id="dataTable" class="table table-striped table-bordered">
        <thead class="bg-indigo-1 text-white">
        <tr>
            <th>Client ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Contact</th>
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

{{-- assign client modal--}}
<!-- <div class="modal fade" id="assignModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Assign Client</h4>
            </div>
            <div class="modal-body">
                <form id="assignForm" name="assignForm" class="form-horizontal">
                    <input type="hidden" name="assign_id" id="assign_id">
                    <input type="hidden" name="action" id="action">
                    <div class="form-group">
                        <label for="fullname" class="col-sm-12 control-label">Client Full Name:</label>
                        <div class="col-sm-12">
                            <h5 id="fullname"></h5>
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
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> -->

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
            ajax: "{{ url('client') }}",
            columns: [
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'id', name: 'id'},
                {data: 'fname', name: 'fname'},
                {data: 'lname', name: 'lname'},
                {data: 'email', name: 'email'},
                {data: 'contact_num', name: 'contact_num'},
                {
                    data: 'is_active', name: 'is_active',
                    "render": function (data, type, full, meta) {
                        var output = '';

                        if(full.is_pending == 1){
                            output = '<span class="text-info font-weight-bold"">Pending</span>';
                        }else{
                            if(full.is_active == 1){
                                output = '<span class="text-success font-weight-bold">Active</span>';
                            }else{
                                output = '<span class="text-danger font-weight-bold"">In-Active</span>';
                            }
                        }

                        return output;
                    },
                },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // create new client
        $('#createNewClient').click(function () {
            $('#saveBtn').html("Create");
            $('#client_id').val('');
            $('#clientForm').trigger("reset");
            $('#modelHeading').html("Create New Client");
            $('#ajaxModel').modal('show');
            $("#password").val(randomPassword(10));
            $("#div_password").show();
            $("#action").val('');
        });

        // create or update client
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Saving..');

            $.ajax({
                data: $('#clientForm').serialize(),
                url: "{{ url('client') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#clientForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                    $('#saveBtn').html('Save');
                    swal("Information", data.message);
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save');
                }
            });
        });

        // edit client
        $('body').on('click', '.editClient', function () {
            var client_id = $(this).data('id');
            $.get("{{ url('client') }}" + '/' + client_id + '/edit', function (data) {
                $('#modelHeading').html("Edit Client Profile");
                $('#saveBtn').html('Update');
                $('#ajaxModel').modal('show');
                $('#client_id').val(data.id);
                $('#fname').val(data.fname);
                $('#mname').val(data.mname);
                $('#lname').val(data.lname);
                $('#email').val(data.email);
                $('#contact_num').val(data.contact_num);
                $("#div_password").hide();
                $("#action").val('update_client_profile');
            })
        });

        // // assign client
        // $('body').on('click', '.assignClient', function () {
        //     var client_id = $(this).data('id');
        //     $.get("{{ url('client') }}" + '/' + client_id + '/edit', function (data) {
        //         $('#assignModal').modal('show');
        //         $('#assign_id').val(data.id);
        //         $('#fullname').html(data.fname + " " + data.lname);
        //         $("#action").val("assign_client");
        //     })
        // });

        // // assign client
        // $('body').on('submit', '#assignForm', function (e) {
        //     e.preventDefault();
        //     $.ajax({
        //         data: $('#assignForm').serialize(),
        //         url: "{{ url('client') }}",
        //         type: "POST",
        //         dataType: 'json',
        //         success: function (data) {
        //             $('#assignForm').trigger("reset");
        //             $('#assignModal').modal('hide');
        //             table.draw();
        //             $('#saveBtn').html('Save');
        //             swal("Information", data.message);
        //         },
        //         error: function (data) {
        //             console.log('Error:', data);
        //             $('#saveBtn').html('Save');
        //         }
        //     });
        // });

        // delete client
        $('body').on('click', '.deleteClient', function () {
            var client_id = $(this).data("id");
            var stat = $(this).data("stat");

            var swal_text = '';

            if(stat == 0){
                swal_text = 'Once deactivated, this user cannot be able to login!';
            }else if(stat == 1){
                swal_text = 'Once activated, this user will be able to login!';
            }else{
                swal_text = 'Once activated, this user will be approved and able to login!';
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
                        url: "{{ url('client') }}" + '/' + client_id,
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



        //--------------------------FUNCTION----------------------------------//
        function randomPassword(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }

    });
</script>
@endsection
