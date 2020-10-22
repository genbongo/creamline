@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <h4 class="center">Todays Delivery as of <span id="date_here"></span></h4>
        </div>
    </div>
    <table id="dataTable" class="table table-striped table-bordered">
        <thead class="bg-indigo-1 text-white">
        <tr>
            <th>ID</th>
            <th>Client</th>
            <th>Store Name</th>
            <th>Store Address</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    
</div>

{{-- update failed delivery--}}
<div class="modal fade" id="updateFailedOrder" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Failed Delivery Report</h4>
            </div>
            <div class="modal-body">
                <form id="frmCancelledOrder" name="frmCancelledOrder" class="form-horizontal">
                    <input type="hidden" name="failed_order_id" id="failed_order_id">
                    <div class="form-group">
                        <label for="txt_cancelled_reason" class="col-sm-12 control-label">Reason:</label>
                        <div class="col-sm-12">
                            <textarea name="txt_cancelled_reason" class="form-control" id="txt_cancelled_reason" style="height: 150px;"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-offset-12 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btnConfirmCancelledOrder">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- update failed delivery--}}
<div class="modal fade" id="displayOrderDetails" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Order Details</h4>
            </div>
            <div class="modal-body">
                <form id="frmPendingOrder" name="frmPendingOrder" class="form-horizontal">
                    <input type="hidden" name="failed_order_id" id="failed_order_id">
                    <div class="form-group">
                        <label for="txt_product" class="col-sm-12 control-label">Product</label>
                        <div class="col-sm-12">
                            <input class="form-control" id="txt_product" readonly disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txt_qty" class="col-sm-12 control-label">Quantity</label>
                        <div class="col-sm-12">
                            <input class="form-control" id="txt_qty" readonly disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txt_amount" class="col-sm-12 control-label">Amount</label>
                        <div class="col-sm-12">
                            <input class="form-control" id="txt_amount" readonly disabled>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(() => {

        //ajax setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //display the date here...
        $("#date_here").html(moment().format('MMMM D YYYY'));

        // datatable
        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('main') }}",
            columns: [
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {
                    data: 'id', name: 'id',
                    "render": function(data, type, full, meta){
                        return '<a href="#" class="btnDisplayOrderDetail" data-prod="'+ full.name +'" data-qty="'+ full.quantity_ordered +'" data-total="'+ full.ordered_total_price +'">'+ data +'</a>'
                    }
                },
                {
                    data: 'name', name: 'name',
                    "render": function(data, type, full, meta){
                        return full.lname + ', ' + full.fname
                    }
                },
                {data: 'store_name', name: 'store_name'},
                {data: 'store_address', name: 'store_address'},
                {
                    data: 'is_completed', name: 'is_completed',
                    "render": function(data, type, full, meta){
                        let output = ''

                        if(full.is_completed == 1){
                            output = '<span class="text-success font-weight-bold">Completed</span>'
                        }

                        if(full.is_cancelled == 1){
                            output = '<span class="text-danger font-weight-bold">Cancelled</span>'
                        }

                        return output
                    }
                },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        //when complete order button is clicked
        $(document).on('click', '.editCompleteOrder', function() {
            swal({
                title: "Are you sure?",
                text: "Once confirmed, it will set the order as completed.",
                icon: "warning",
                buttons: true,
                dangerMode: false,
            })
            .then((isTrue) => {
                if (isTrue) {

                    //get the current order id
                    const order_id = $(this).attr("data-id");

                    //set params
                    const params = {
                        order_id,
                        "action" : "completed"
                    }

                    $.ajax({
                        type: "POST",
                        url: "{{ url('main') }}",
                        data: params,
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
        })

        //when cancel order is clicked
        $(document).on('click', '.editCancelOrder', function() {

            //get the current id
            const order_id = $(this).attr("data-id");

            //set the id to DOM
            $("#failed_order_id").val(order_id)

            //show the modal
            $('#updateFailedOrder').modal("show");
        })

        //when cancel order is clicked
        $(document).on('click', '.btnDisplayOrderDetail', function() {

            //get the current id
            const product = $(this).attr("data-prod");
            const qty = $(this).attr("data-qty");
            const amount = $(this).attr("data-total");

            //set the data to DOM
            $("#txt_product").val(product)
            $("#txt_qty").val(qty)
            $("#txt_amount").val(amount)

            //show the modal
            $('#displayOrderDetails').modal("show");
        })

        //when confirm button is clicked
        $("#frmCancelledOrder").on('submit', function(e) {

            e.preventDefault();

            //get the data
            const order_id = $("#failed_order_id").val();
            const reason = $("#txt_cancelled_reason").val();

            if(reason === ''){
                return swal("Error", "Please fill in the reason!")
            }

            //set parameters
            const params = {
                order_id,
                reason,
                "action": "cancel"
            }

            $.ajax({
                type: "POST",
                url: "{{ url('main') }}",
                data: params,
                success: function (data) {

                    //hide the modal
                    $('#updateFailedOrder').modal("hide");

                    table.draw();
                    swal(data.message, {
                        icon: "success",
                    });
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });

        })
    })
</script>

@endsection