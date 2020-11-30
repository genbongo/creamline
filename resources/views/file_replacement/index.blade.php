@extends('layouts.app')
@inject('products','App\Product')

@section('content')
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <h4 class="center">File Replacement</h4>
            <button class="btn btn-info ml-auto" id="createNewProdReport">Create File Replacement</button>
        </div>
    </div>
    <br>
    <table id="dataTable" class="table table-striped table-bordered">
        <thead class="bg-indigo-1 text-white">
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Images</th>
            <th>Quantity</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

{{-- create/update file_replacement modal--}}
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="prodReportForm" name="prodReportForm" class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" id="fileCount" name="fileCount">
                        <label>Store name:</label>
                        <select class="form-control" id="store_id" name="store_id">
                            <option value="">Please select a store</option>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->store_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Product name:</label>
                        <select class="form-control" id="product_id" name="product_id">
                            <option value="">Please select a product</option>
                            @foreach($products->get() as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Quantity:</label>
                        <input type="text" class="form-control" id="quantity" name="quantity">
                    </div>
                    <div class="form-group">
                        <label>Size:</label>
                        <select class="form-control" id="size_id" name="size_id"></select>
                    </div>
                    <div class="form-group">
                        <label>Flavor:</label>
                        <select class="form-control" id="flavor_id" name="flavor_id"></select>
                    </div>
                    <div class="form-group">
                        <label class="new-avatar hidden"><span class="far fa-plus-square"></span>
                            <input id="file_report_image" name="file_report_image[]" type="file" multiple required="" class="text-center center-block file-upload"/>
                        </label>
                    </div>
                    <div class="form-group">
                        <button style="width: 100%;" type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- display file images --}}
<div class="modal fade" id="displayReasonModal" aria-hidden="true">
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
            ajax: "{{ url('file_replacement') }}",
            columns: [
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'reportid', name: 'reportid'},
                {data: 'prodname', name: 'prodname'},
                {
                    data: 'file_report_image', name: 'file_report_image',
                    render: function(data, type, full, meta){
                        console.log(full)
                        let output = ''
                        if(data != ""){
                            output = "<a href='#' class='btnDisplayImages' data-val='"+full.reportid+"'>"+full.file_report_image+"</a>"
                        }

                        return output
                    }
                },
                {data: 'quantity', name: 'quantity'},
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
                // {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // create new file_replacement
        $('#createNewProdReport').click(function () {
            $('#saveBtn').html("Create");
            $('#prodReport_id').val('');
            $('#prodReportForm').trigger("reset");
            $('#modelHeading').html("Create New File Replacement");
            $('#ajaxModel').modal('show');
        });

        // create or update file_replacement
        $('#prodReportForm').on('submit', function (e) {
            e.preventDefault();

            if($("#store_id").val() == ""){
                return swal("Error", "Please select a store!")
            }
            if($("#product_id").val() == ""){
                return swal("Error", "Please select a product!")
            }

            $.ajax({
                url:"{{ url('file_replacement') }}",
                method:"POST",
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('#prodReportForm').trigger("reset");
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

        //if product is changed
        $('#product_id').change(function(){

            //store the current id of the product
            const currentID = $("#product_id option:selected").val();
            
            //get the vairations of the current product
            $.get("{{ url('edit_product') }}" + '/' + currentID, function (data) {

                //variations here such as flavors and size
                var flavor_list = data.variation.flavor.slice(0, -1).split(",")
                var size_list = data.variation.size.slice(0, -1).split(",")

                var flavor_output = '';
                var size_output = '';
                for(var i = 0; i < flavor_list.length; i++){
                    flavor_output += '<option value="'+flavor_list[i]+'">'+flavor_list[i]+'</option>'
                }
                for(var i = 0; i < size_list.length; i++){
                    size_output += '<option value="'+size_list[i]+'">'+size_list[i]+'</option>'
                }
                
                //embed it to DOM
                $("#flavor_id").empty().append(flavor_output)
                $("#size_id").empty().append(size_output)

            })
        })

        //when display dot is clicked
        $(document).on('click', '.btnDisplayImages', function(){

            //get the data
            const product_report_id = $(this).attr("data-val")

            $.get("{{ url('file_replacement') }}" + '/' + product_report_id + '/edit', function (data) {

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
            $("#displayReasonModal").modal("show")
        })
    });
</script>
@endsection
