@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <h4 class="center">Loss Report</h4>
        </div>
    </div>

    <table id="lossReportTable" class="table table-striped table-bordered">
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
            <!-- <th>Attempt</th>
            <th>Reason</th> -->
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(() => {

        //ajax setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /* -------------------------------------------------------------------------------
                                    TRANSACTION HISTORY LIST
        -------------------------------------------------------------------------------- */
        // datatable
        var lossReportTable = $('#lossReportTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('loss') }}",
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
                // {
                //     data: 'attempt', name: 'attempt',
                //     render: function(data, type, full, meta){

                //         let output = parseInt(data) + 1
                //         let times = output > 1 ? "times" : "time"

                //         return output + " " + times
                //     }
                // },
                // {
                //     data: 'reason', name: 'reason',
                //     render: function(data, type, full, meta){
                //         let output = ''
                //         if(data != ""){
                //             output = "<a href='#' class='btnDisplayReason' data-reason='"+data+"'>...</a>"
                //         }

                //         return output
                //     }
                // },
                {
                    data: 'is_completed', name: 'is_completed',
                    render: function(data, type, full, meta){
                        let output = full.is_approved == 1 ? '<span class="text-info font-weight-bold">Approved</span><br/>' : '<span class="text-danger font-weight-bold">Pending</span><br/>';

                        if(full.is_completed == 1){
                            output = '<span class="text-success font-weight-bold">Completed</span>'
                        }

                        return output
                    }
                },
            ]
        });

    })
</script>

@endsection