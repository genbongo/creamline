@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <h4 class="center">Order</h4>
        </div>
    </div>

    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header-1">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#order-tab-pending" role="tab" aria-controls="profile" aria-selected="true">PENDING</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#order-tab-undelivered" role="tab" aria-selected="false">UNDELIVERED</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#order-replacement" role="tab" aria-selected="false">REPLACEMENT</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#order-damage" role="tab" aria-selected="false">DAMAGE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#order-tab-tran-his" role="tab" aria-selected="false">TRANSACTION HISTORY</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="order-tab-pending" role="tabpanel">
                        <table style="width: 100%;" id="dataTable" class="table table-striped table-bordered">
                            <thead class="bg-indigo-1 text-white">
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Image</th>
                                <th>Qty</th>
                                <th>Amount</th>
                                <th>Date Ordered</th>
                                <th>Delivery Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade show" id="order-tab-undelivered" role="tabpanel">
                        <table style="width: 100%;" id="undeliveredTable" class="table table-striped table-bordered">
                            <thead class="bg-indigo-1 text-white">
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Image</th>
                                <th>Qty</th>
                                <th>Amount</th>
                                <th>Date Ordered</th>
                                <th>Delivery Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade show" id="order-replacement" role="tabpanel">
                        <table style="width: 100%;" id="replacementTable" class="table table-striped table-bordered">
                        <thead class="bg-indigo-1 text-white">
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Products</th>
                            <th>Images</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th width="280px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade show" id="order-damage" role="tabpanel">
                        <table style="width: 100%;" id="damageTable" class="table table-striped table-bordered">
                        <thead class="bg-indigo-1 text-white">
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Product Name</th>
                            <th>Images</th>
                            <th width="280px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade show" id="order-tab-tran-his" role="tabpanel">
                        <table style="width: 100%;" id="historyTable" class="table table-striped table-bordered">
                            <thead class="bg-indigo-1 text-white">
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Image</th>
                                <th>Qty</th>
                                <th>Amount</th>
                                <th>Date Ordered</th>
                                <th>Delivery Date</th>
                                <th>Attempt</th>
                                <th>Reason</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- update pending modal--}}
<div class="modal fade" id="updatePendingModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Approve Order</h4>
            </div>
            <div class="modal-body">
                <form id="frmPendingOrder" name="frmPendingOrder" class="form-horizontal">
                    <input type="hidden" name="pending_order_id" id="pending_order_id">
                    <input type="hidden" name="pending_product_id" id="pending_product_id">
                    <input type="hidden" name="pending_product_qty" id="pending_product_qty">
                    <input type="hidden" name="pending_contact" id="pending_contact">
                    <input type="hidden" name="pending_date_to_display" id="pending_date_to_display">
                    <input type="hidden" name="pending_amount" id="pending_amount">
                    <input type="hidden" name="pending_client_id" id="pending_client_id">
                    <div class="form-group">
                        <label for="txt_pending_product" class="col-sm-12 control-label">Product</label>
                        <div class="col-sm-12">
                            <input class="form-control" id="txt_pending_product" readonly disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txt_pending_qty" class="col-sm-12 control-label">Quantity</label>
                        <div class="col-sm-12">
                            <input class="form-control" id="txt_pending_qty" readonly disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txt_pending_amount" class="col-sm-12 control-label">Amount</label>
                        <div class="col-sm-12">
                            <input class="form-control" id="txt_pending_amount" readonly disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txt_pending_delivery_date" class="col-sm-12 control-label">Delivery date</label>
                        <div class="col-sm-12">
                            <input type="date" name="delivery_date" class="form-control" id="delivery_date">
                        </div>
                    </div>
                    <div class="col-sm-offset-12 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btnConfirmPendingOrder">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- update reschedule modal--}}
<div class="modal fade" id="updateReschedModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reschedule Order</h4>
            </div>
            <div class="modal-body">
                <form id="frmReschedOrder" name="frmReschedOrder" class="form-horizontal">
                    <input type="hidden" name="resched_order_id" id="resched_order_id">
                    <input type="hidden" name="resched_contact" id="resched_contact">
                    <input type="hidden" name="resched_date_to_display" id="resched_date_to_display">
                    <input type="hidden" name="resched_amount" id="resched_amount">
                    <div class="form-group">
                        <label for="txt_resched_product" class="col-sm-12 control-label">Product</label>
                        <div class="col-sm-12">
                            <input class="form-control" id="txt_resched_product" readonly disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txt_resched_qty" class="col-sm-12 control-label">Quantity</label>
                        <div class="col-sm-12">
                            <input class="form-control" id="txt_resched_qty" readonly disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txt_resched_amount" class="col-sm-12 control-label">Amount</label>
                        <div class="col-sm-12">
                            <input class="form-control" id="txt_resched_amount" readonly disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txt_resched_delivery_date" class="col-sm-12 control-label">Delivery date</label>
                        <div class="col-sm-12">
                            <input type="date" name="txt_resched_delivery_date" class="form-control" id="txt_resched_delivery_date">
                        </div>
                    </div>
                    <div class="col-sm-offset-12 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btnConfirmReschedOrder">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- display reason modal--}}
<div class="modal fade" id="displayReasonModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Failed Delivery Report</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="txt_history_reason" class="col-sm-12 control-label">Reason for failed delivery:</label>
                    <div class="col-sm-12">
                        <textarea class="form-control" id="txt_history_reason" readonly disabled></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- display file images --}}
<div class="modal fade" id="displayModalImagesHere" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Product Report Images</h4>
            </div>
            <div class="modal-body">
                <div class="row text-center text-lg-left" id="divModalImages"></div>
            </div>
        </div>
    </div>
</div>

{{-- set replacement schedule--}}
<div class="modal fade" id="fileReplacementDelivery" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delivery Schedule</h4>
            </div>
            <div class="modal-body">
                <form id="replacementDelivery" name="replacementDelivery" class="form-horizontal">
                    <input type="hidden" name="id" id="reportId" value="">
                     <input type="hidden" name="replacement_delivery_to_display" id="replacement_delivery_to_display">
                    <div class="form-group">
                        <label for="txt_resched_delivery_date" class="col-sm-12 control-label">Delivery date</label>
                        <div class="col-sm-12">
                            <input type="date" name="txt_replacement_delivery_date" class="form-control" id="txt_replacement_delivery_date">
                        </div>
                    </div>
                    <div class="col-sm-offset-12 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btnConfirmReschedOrder">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- display file images --}}
<div class="modal fade" id="displayFileModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Product Report Images</h4>
            </div>
            <div class="modal-body">
                <div class="row text-center text-lg-left" id="divContentImages"></div>
            </div>
        </div>
    </div>
</div>

{{-- display Products --}}
<div class="modal fade" id="displayProductsModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Products</h4>
            </div>
            <div class="modal-body" id="divModalProducts">
                <div class="row">
                    <div class="col-4"><b> Product Name </b></div>
                    <div class="col-4"><b> Size </b></div>
                    <div class="col-4"><b> Quantity </b></div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row text-center">
                    <button class="btn btn-success" id="replaceProduct">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        function onHashChange() {
            var hash = window.location.hash;
            console.log(hash)
            if (hash) {
                // using ES6 template string syntax
                $(`[data-toggle="tab"][href="${hash}"]`).trigger('click');
            }
        }

        window.addEventListener('hashchange', onHashChange, false);
        onHashChange();
    });
    $(() => {

        //ajax setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /* -------------------------------------------------------------------------------
                                        PENDING ORDER LIST
        -------------------------------------------------------------------------------- */

        // datatable
        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('order') }}",
            data: { 
              ajaxid: 4
            },
            columns: [
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'id', name: 'id'},
                {
                    data: 'fname', name: 'fname',
                    "render": function(data, type, full, meta){
                        return full.lname + ', ' + full.fname
                    }
                },
                {data: 'name', name: 'name'},
                {   
                    data: 'product_image', name: 'product_image',
                    "render": function (data, type, full, meta) {
                        return "<a data-fancybox='' href='{{ URL('img/product') }}/"+ data +"'><img src='{{ URL('img/product') }}/"+ data +"' height='20'></a>";
                    },
                },
                {
                    data: 'quantity_ordered', name: 'quantity_ordered',
                    "render": function(data, type, full, meta){
                        return data + " pcs"
                    }
                },
                {
                    data: 'ordered_total_price', name: 'ordered_total_price',
                    "render": function(data, type, full, meta){
                        return "&#x20b1; " + data
                    }
                },
                {
                    data: 'created_at', name: 'created_at',
                    "render": function (data, type, full, meta) {
                        return moment(data).format('MMMM D YYYY, h:mm:ss a');
                    },
                },
                {
                    data: 'delivery_date', name: 'delivery_date',
                    "render": function (data, type, full, meta) {
                        let output = '';
                        if(data === '1010-10-10'){
                            output = '<span class="text-info font-weight-bold">(Not set)</span>'
                        }else{
                            output = moment(data).format('MMMM D YYYY');
                        }

                        return output
                    },
                },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // edit pending order
        $('body').on('click', '.editPendingOrder', function () {
            //get the data
            const order_id = $(this).attr("data-id");
            const product_id = $(this).attr("data-prodid");
            const contact = $(this).attr("data-num");
            const prodname = $(this).attr("data-prodname");
            const qty = $(this).attr("data-qty");
            const total = $(this).attr("data-total");
            const client_id = $(this).attr("data-client");

            //set the data
            $("#pending_order_id").val(order_id);
            $("#pending_product_id").val(product_id);
            $("#pending_product_qty").val(qty);
            $("#pending_contact").val(contact);
            $("#txt_pending_product").val(prodname);
            $("#pending_amount").val(total);
            $("#txt_pending_qty").val(qty);
            $("#txt_pending_amount").val(total);
            $("#pending_client_id").val(client_id);
            
            
            $('#updatePendingModal').modal('show');
        });

        //when button confirm order is clicked
        $("#frmPendingOrder").on('submit', function(e) {
            e.preventDefault();

            if(!$("#delivery_date").val()){

                swal("Error", "Please select a date to deliver!")

            }else{
                //get the value of delivery date
                const delivery_date = moment($("#delivery_date").val()).format('MMMM D YYYY');

                //set the value for date to disdplay
                $("#pending_date_to_display").val(delivery_date);

                //disable the button
                $("#btnConfirmPendingOrder").attr("disabled", "disabled");

                $.ajax({
                    url:"{{ url('order') }}",
                    method:"POST",
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        // console.log("printing data");
                        // console.log(data);

                        swal("Information", "Order has been successfully confirmed!").then(res => {
                            $('#updatePendingModal').modal('hide');
                            // table.draw();
                            drawAllTable()
                        })

                        //disable the button
                        $("#btnConfirmPendingOrder").removeAttr("disabled");

                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }

        })





        /* -------------------------------------------------------------------------------
                                        UNDELIVERED LIST
        -------------------------------------------------------------------------------- */
        // datatable
        var undeliverTable = $('#undeliveredTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('undeliver') }}",
            columns: [
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'id', name: 'id'},
                {
                    data: 'fname', name: 'fname',
                    "render": function(data, type, full, meta){
                        return full.lname + ', ' + full.fname
                    }
                },
                {data: 'name', name: 'name'},
                {   
                    data: 'product_image', name: 'product_image',
                    "render": function (data, type, full, meta) {
                        return "<a data-fancybox='' href='{{ URL('img/product') }}/"+ data +"'><img src='{{ URL('img/product') }}/"+ data +"' height='20'></a>";
                    },
                },
                {
                    data: 'quantity_ordered', name: 'quantity_ordered',
                    "render": function(data, type, full, meta){
                        return data + " pcs"
                    }
                },
                {
                    data: 'ordered_total_price', name: 'ordered_total_price',
                    "render": function(data, type, full, meta){
                        return "&#x20b1; " + data
                    }
                },
                {
                    data: 'created_at', name: 'created_at',
                    "render": function (data, type, full, meta) {
                        return moment(data).format('MMMM D YYYY, h:mm:ss a');
                    },
                },
                {
                    data: 'delivery_date', name: 'delivery_date',
                    "render": function (data, type, full, meta) {
                        let output = '';
                        if(full.is_cancelled == 1){
                            output = '<span class="text-danger font-weight-bold">(To be reschedule)</span>'
                        }else{
                            output = moment(data).format('MMMM D YYYY');
                        }

                        return output
                    },
                },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // edit resched order
        $('body').on('click', '.editReschedOrder', function () {
            //get the data
            const order_id = $(this).attr("data-id");
            const contact = $(this).attr("data-num");
            const prodname = $(this).attr("data-prodname");
            const qty = $(this).attr("data-qty");
            const total = $(this).attr("data-total");

            //set the data
            $("#resched_order_id").val(order_id);
            $("#resched_contact").val(contact);
            $("#txt_resched_product").val(prodname);
            $("#resched_amount").val(total);
            $("#txt_resched_qty").val(qty);
            $("#txt_resched_amount").val(total);
            
            $('#updateReschedModal').modal('show');
        });

        //when button confirm order is clicked
        $("#frmReschedOrder").on('submit', function(e) {
            e.preventDefault();

            if(!$("#txt_resched_delivery_date").val()){

                swal("Error", "Please select a date to reschedule the delivery!")

            }else{
                //get the value of delivery date
                const resched_delivery_date = moment($("#txt_resched_delivery_date").val()).format('MMMM D YYYY');

                //set the value for date to disdplay
                $("#resched_date_to_display").val(resched_delivery_date);

                //disable the button
                $("#btnConfirmReschedOrder").attr("disabled", "disabled");

                $.ajax({
                    url:"{{ url('undeliver') }}",
                    method:"POST",
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        console.log("printing data");
                        console.log(data);

                        swal("Information", "Order has been successfully confirmed!").then(res => {
                            $('#updateReschedModal').modal('hide');
                            // undeliverTable.draw();
                            drawAllTable()
                        })

                        //disable the button
                        $("#btnConfirmReschedOrder").removeAttr("disabled");

                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }

        })


        $(document).on('click', '#replaceProduct', function() {
            const inpts = $('input[name ="quantity')
            let arrs = [];

            inpts.map(input => {
                arrs.push({
                    'id': inpts[input].id,
                    'value': inpts[input].value
                })
            });

            const formData = new FormData;
            formData.append('props', JSON.stringify(arrs));
            $.ajax({
                url:"{{ url('update/replacement') }}",
                method:"POST",
                data: formData,
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    drawAllTable()
                    //disable the button
                    $('#displayProductsModal').modal('hide');
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

        /* -------------------------------------------------------------------------------
                                    REPLACEMENT LIST
        -------------------------------------------------------------------------------- */

        $(document).on('click', '.displayProducts', function(){
            const products =JSON.parse($(this).attr("data-val"));
            $('#displayProductsModal').modal('show');
            $('#divModalProducts').empty();

            var header = `<div class="row">
                            <div class="col-4"><b> Product Name </b></div>
                            <div class="col-4"><b> Size </b></div>
                            <div class="col-4"><b> Quantity </b></div>
                        </div>`
            $('#divModalProducts').append(header)

            products.map(product => {
                var jsx =`
                    <div class="row">
                        <div class="col-4">
                            ${product.name}
                        </div>
                         <div class="col-4">
                            ${product.size}
                        </div>
                         <div class="col-4">
                            <input type="number" id="${product.id}" value="${product.quantity}" name="quantity" class="form-control" />
                        </div>
                    </div>`;
                $('#divModalProducts').append(jsx)
            })
        });

        $(document).on('click', '.btnDisplayImages', function(){
            $('#divContentImages').empty()
            const images =JSON.parse($(this).attr("data-val"));
            $('#displayFileModal').modal('show');
            images.map(image => {
                var jsx =`
                    <div class="row">
                        <div class="col-4 m-2">
                            <img src="{{ URL('img/filereport') }}/${image.file_report_image}" style="height:101px;"/>
                        </div>
                    </div>`;
                $('#divContentImages').append(jsx)
            })
        });
        // datatable
        var replacementTable = $('#replacementTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('order_replacement') }}",
            columns: [
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'id', name: 'id'},
                {
                    data: 'client', name: 'client',
                    render: function(data, type, full, meta){
                        return full.client.lname + ', ' + full.client.fname;
                    }
                },
                {
                    data: 'products', 
                    name: 'products',
                    render: function(data, type, full, meta) {
                        return "<a href='#' class='displayProducts' data-val='"+full.products+"'>View Products</a>"
                    }
                },
                {
                    data: 'file_report_image', name: 'file_report_image',
                    render: function(data, type, full, meta){
                        let output = ''
                        if(data != ""){
                            output = "<a href='#' class='btnDisplayImages' data-val='"+full.images+"'>View Images</a>"
                        }

                        return output
                    }
                },
                {data: 'quantity', name: 'quantity'},
                {
                    data: 'is_replaced', name: 'is_replaced',
                    "render": function (data, type, full, meta) {
                        var output = '';

                        if (full.delivery_date == '0000-00-00') {
                            if(data === 0){
                            output = '<span class="text-warning font-weight-bold">Pending</span>'
                            }else if(data === 1){
                                output = '<span class="text-success font-weight-bold">Approved</span>'
                            }else{
                                output = '<span class="text-danger font-weight-bold">Not Approved</span>'
                            }
                        } else {
                            output = '<span class="text-success font-weight-bold">On-delivery</span>'
                        }
                        return output;
                    }
                },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        //display when set delivery is clicked
        $(document).on('click', '.setDeliver', function(e){

            const product_report_id = $(this).attr("data-id")

            $("#reportId").val(product_report_id);

            $("#fileReplacementDelivery").modal("show");
        });

        $("#replacementDelivery").on('submit', function(e) {
            e.preventDefault();

            if(!$("#txt_replacement_delivery_date").val()){

                swal("Error", "Please select a date to reschedule the delivery!")

            }else{
                //get the value of delivery date
                const resched_delivery_date = moment($("#txt_replacement_delivery_date").val()).format('MMMM D YYYY');

                //set the value for date to disdplay
                $("#replacement_delivery_to_display").val(resched_delivery_date);

                //disable the button
                $("#btnConfirmReschedOrder").attr("disabled", "disabled");

                $.ajax({
                    url:"{{ url('replacement/set-deliver') }}",
                    method:"POST",
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        console.log("printing data");
                        console.log(data);

                        swal("Information", "Order has been successfully confirmed!").then(res => {
                            $('#updateReschedModal').modal('hide');
                            // undeliverTable.draw();
                            drawAllTable()
                        })

                        $("#fileReplacementDelivery").modal("hide");

                        //disable the button
                        $("#btnConfirmReschedOrder").removeAttr("disabled");

                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }

        })

        //when display dot is clicked
        $(document).on('click', '.btnDisplayImages', function(){

            //get the data
            const product_report_id = $(this).attr("data-val")

            $.get("{{ url('order_replacement') }}" + '/' + product_report_id + '/edit', function (data) {

                var output = '';

                const file_images = data.product_file_report;

                for(var i = 0; i < file_images.length; i++){
                    console.log(file_images[i])
                    output += '<div class="col-lg-4 col-md-4 col-4">' +
                                "<a data-fancybox='' href='{{ URL('img/filereport') }}/"+ file_images[i].file_report_image +"'><img src='{{ URL('img/filereport') }}/"+ file_images[i].file_report_image +"' class='img-fluid img-thumbnail card-img-top' style='height:100px;width:100px'></a>" +
                            '</div>'
                }

                $("#divModalImages").html(output)

            })

            //display the modal
            $("#displayModalImagesHere").modal("show")
        })


        //when replacement order is approved
        $(document).on('click', '.editReplacementOrder', function(){
            const reportid = $(this).attr("data-id")
            const clientid = $(this).attr("data-clientid")
            const params = {
                reportid,
                clientid,
                action: "approve_replacement"
            }
            swal({
                title: "Are you sure?",
                text: "Once approved, it will be confirmed",
                icon: "warning",
                buttons: true,
                dangerMode: false,
            })
            .then((isTrue) => {
                if (isTrue) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('order_replacement') }}",
                        data: params,
                        success: function (data) {
                            drawAllTable();
                            swal(data.message, {
                                icon: "success",
                            });
                            // console.log(data)
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });
        })

        //when replacement order is approved
        $(document).on('click', '.editDisapproveReplacement', function(){
            const reportid = $(this).attr("data-id")
            const clientid = $(this).attr("data-clientid")
            const params = {
                reportid,
                clientid,
                action: "disapprove_replacement"
            }
            swal({
                title: "Are you sure?",
                text: "Once disapproved, it will be not be undone!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((isTrue) => {
                if (isTrue) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('order_replacement') }}",
                        data: params,
                        success: function (data) {
                            drawAllTable();
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




        /* -------------------------------------------------------------------------------
                                    DAMAGE LIST
        -------------------------------------------------------------------------------- */
        // datatable
        var damageTable = $('#damageTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('order_damage') }}",
            columns: [
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'damageid', name: 'damageid'},
                {
                    data: 'clientName', name: 'clientName',
                    render: function(data, type, full, meta){
                        return full.lname + ', ' + full.fname;
                    }
                },
                {data: 'prodname', name: 'prodname'},
                {
                    data: 'is_replaced', name: 'is_replaced',
                    "render": function (data, type, full, meta) {
                        var output = '';
                        if(data === 0){
                            output = '<span class="text-warning font-weight-bold">Pending</span>'
                        }else if(data === 1){
                            output = '<span class="text-success font-weight-bold">Approved</span>'
                        }else{
                            output = '<span class="text-danger font-weight-bold">Not Approved</span>'
                        }
                        return output;
                    }
                },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        //when display dot is clicked
        $(document).on('click', '.btnDisplayImages', function(){

            //get the data
            const product_damage_id = $(this).attr("data-val")

            $.get("{{ url('order_damage') }}" + '/' + product_damage_id + '/edit', function (data) {

                var output = '';

                const file_images = data.product_file_damage;

                for(var i = 0; i < file_images.length; i++){
                    console.log(file_images[i])
                    output += '<div class="col-lg-4 col-md-4 col-4">' +
                                "<a data-fancybox='' href='{{ URL('img/filedamage') }}/"+ file_images[i].file_damage_image +"'><img src='{{ URL('img/filedamage') }}/"+ file_images[i].file_damage_image +"' class='img-fluid img-thumbnail card-img-top' style='height:100px;width:100px'></a>" +
                            '</div>'
                }

                $("#divModalImages").html(output)

            })

            //display the modal
            $("#displayModalImagesHere").modal("show")
        })

        //when damage order is approved
        $(document).on('click', '.editDamageOrder', function(){
            const damageid = $(this).attr("data-id")
            const clientid = $(this).attr("data-clientid")
            const params = {
                damageid,
                clientid,
                action: "approve_damage"
            }
            swal({
                title: "Are you sure?",
                text: "Once approved, it will be confirmed",
                icon: "warning",
                buttons: true,
                dangerMode: false,
            })
            .then((isTrue) => {
                if (isTrue) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('order_damage') }}",
                        data: params,
                        success: function (data) {
                            drawAllTable();
                            swal(data.message, {
                                icon: "success",
                            });
                            // console.log(data)
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });
        })

        //when damage order is approved
        $(document).on('click', '.editDisapproveDamage', function(){
            const damageid = $(this).attr("data-id")
            const clientid = $(this).attr("data-clientid")
            const params = {
                damageid,
                clientid,
                action: "disapprove_damage"
            }
            swal({
                title: "Are you sure?",
                text: "Once disapproved, it will be not be undone!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((isTrue) => {
                if (isTrue) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('order_damage') }}",
                        data: params,
                        success: function (data) {
                            drawAllTable();
                            swal(data.message, {
                                icon: "success",
                            });
                            // console.log(data)
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });
        })






        /* -------------------------------------------------------------------------------
                                    TRANSACTION HISTORY LIST
        -------------------------------------------------------------------------------- */
        // datatable
        var historyTable = $('#historyTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('history') }}",
            columns: [
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'id', name: 'id'},
                {
                    data: 'fname', name: 'fname',
                    "render": function(data, type, full, meta){
                        return full.lname + ', ' + full.fname
                    }
                },
                {data: 'name', name: 'name'},
                {   
                    data: 'product_image', name: 'product_image',
                    "render": function (data, type, full, meta) {
                        return "<a data-fancybox='' href='{{ URL('img/product') }}/"+ data +"'><img src='{{ URL('img/product') }}/"+ data +"' height='20'></a>";
                    },
                },
                {
                    data: 'quantity_ordered', name: 'quantity_ordered',
                    "render": function(data, type, full, meta){
                        return data + " pcs"
                    }
                },
                {
                    data: 'ordered_total_price', name: 'ordered_total_price',
                    "render": function(data, type, full, meta){
                        return "&#x20b1; " + data
                    }
                },
                {
                    data: 'created_at', name: 'created_at',
                    "render": function (data, type, full, meta) {
                        return moment(data).format('MMMM D YYYY');
                    },
                },
                {
                    data: 'delivery_date', name: 'delivery_date',
                    "render": function (data, type, full, meta) {
                        let output = '';
                        if(data === '1010-10-10'){
                            output = '<span class="text-info font-weight-bold">(Not set)</span>'
                        }else{
                            if(full.is_cancelled == 1){
                                output = '<span class="text-danger font-weight-bold">(To be reschedule)</span>'
                            }else{
                                output = moment(data).format('MMMM D YYYY');
                            }
                        }


                        return output
                    },
                },
                {
                    data: 'attempt', name: 'attempt',
                    render: function(data, type, full, meta){

                        let output = parseInt(data) + 1
                        let times = output > 1 ? "times" : "time"

                        return output + " " + times
                    }
                },
                {
                    data: 'reason', name: 'reason',
                    render: function(data, type, full, meta){
                        let output = ''
                        if(data != ""){
                            output = "<a href='#' class='btnDisplayReason' data-reason='"+data+"'>...</a>"
                        }

                        return output
                    }
                },
                {
                    data: 'is_completed', name: 'is_completed',
                    render: function(data, type, full, meta){
                        let output = full.is_approved == 1 ? '<span class="text-info font-weight-bold">Approved</span><br/>' : '<span class="text-danger font-weight-bold">Pending</span><br/>';

                        if(full.is_completed == 1){
                            output += '<span class="text-success font-weight-bold">Completed</span>'
                        }
                        if(full.is_cancelled == 1){
                            output += '<span class="text-danger font-weight-bold">Cancelled</span>'
                        }
                        if(full.is_rescheduled == 1){
                            output += '<span class="text-info font-weight-bold">Rescheduled</span>'
                        }

                        return output
                    }
                },
            ]
        });

        //when reason dot is clicked
        $(document).on('click', '.btnDisplayReason', function(){

            //get the data
            const reason = $(this).attr("data-reason")

            //set the data
            $("#txt_history_reason").val(reason)

            //display the modal
            $("#displayReasonModal").modal("show")
        })

        function drawAllTable(){
            table.draw()
            undeliverTable.draw()
            replacementTable.draw()
            damageTable.draw();
            historyTable.draw()
        }

    })
</script>

@endsection