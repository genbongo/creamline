@inject('variation','App\Variation')
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <h4 class="center">Product</h4>
            <button class="btn btn-info ml-auto" id="createNewProduct">Create Product</button>
        </div>
    </div>
    <br>
    <table id="dataTable" class="table table-striped table-bordered">
        <thead class="bg-indigo-1 text-white">
        <tr>
            <th>Product Image</th>
            <th>Product ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Status</th>
            <th width="280px">Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

{{-- create/update product modal--}}
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="product_id" id="product_id">
                            <div class="form-group">
                                <label for="name" class="col-sm-12 control-label">Product Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Product name"
                                           value="" maxlength="50" required="" autocomplete="off" onkeypress="return onlyLetters(event)">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Product Description</label>
                                <div class="col-sm-12">
                                    <input for="description" type="text" class="form-control" id="description" name="description"
                                           placeholder="Enter Product Description"
                                           value="" maxlength="255" required="" autocomplete="off" onkeypress="return onlyLetters(event)">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Product Image</label>
                                <div class="col-sm-12">
                                    <label class="new-avatar hidden"><span class="far fa-plus-square"></span>
                                        <input id="product_image" name="product_image[]" multiple type="file" required="" class="text-center center-block file-upload"/>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Size</label>
                                <div class="col-sm-12">
                                    <input for="size" type="text" class="form-control" id="size"
                                           placeholder="Eg: 110ml"
                                           name="size"
                                           value="" maxlength="255" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Flavor</label>
                                <div class="col-sm-12">
                                    <input for="flavor" type="text" class="form-control" id="flavor"
                                           placeholder="Eg: Manggo"
                                           name="flavor"
                                           value="" maxlength="255" autocomplete="off" onkeypress="return onlyLetters(event)">
                                </div>
                            </div>
                            <div class="col-sm-offset-12 col-sm-10">
                                <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- update stocks modal --}}
<div class="modal fade" id="stockModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading">Update Product Stock</h4>
            </div>
            <div class="modal-body">
                <form id="stockForm" name="stockForm" class="form-horizontal">
                    <input type="hidden" name="stock_id" id="stock_id">
                    <div class="form-group">
                        <label for="stock_product_name" class="col-sm-12 control-label">Product Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="stock_product_name" name="stock_product_name" placeholder="Enter Stock name" value="" maxlength="50" required="" autocomplete="off" disabled readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12 control-label">Stocks</label>
                        <div class="col-sm-12">
                            <input for="stocks" type="number" class="form-control" id="stocks" name="stocks" placeholder="Enter Number of Stocks" value="" maxlength="50" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12 control-label">Threshold</label>
                        <div class="col-sm-12">
                            <input for="threshold" type="number" class="form-control" id="threshold" name="threshold" placeholder="Enter Number of Threshold" value="" maxlength="50" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-offset-12 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="updateStockSubmit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
            ajax: "{{ url('product') }}",
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
                    data: 'is_deleted', name: 'is_deleted',
                    "render": function (data, type, full, meta) {
                        var output = '';
                        if(data == 0){
                            output = '<span class="text-success font-weight-bold">Available</span>';
                        }else{
                            output = '<span class="text-danger font-weight-bold"">Sold-out</span>';
                        }
                        return output;
                    },
                },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // create new product
        $('#createNewProduct').click(function () {
            $('#product_image').attr("required", "");
            $('#saveBtn').html("Create");
            $('#product_id').val('');
            $('#productForm').trigger("reset");
            $('#modelHeading').html("Create New Product");
            $('#ajaxModel').modal('show');
        });

        // create or update product
        $('#productForm').on('submit', function (e) {
            e.preventDefault();
            // $(this).html('Saving..');

            $.ajax({
                url:"{{ url('product') }}",
                method:"POST",
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    // console.log("printing data");
                    // console.log(data);
                    $('#productForm').trigger("reset");
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
        
        // edit stock
        $('body').on('click', '.StockProduct', function () {
            var product_id = $(this).data('id');
            const prodname = $(this).data('name');
            $.get("{{ url('stock') }}" + '/' + product_id + '/edit', function (data) {
                $('#stockModal').modal('show');
                $('#stock_id').val(data.id);
                $('#stock_product_name').val(prodname);
                $('#stocks').val(data.quantity);
                $('#threshold').val(data.threshold);
            })
        });

        //when form for stock is submitted
        $("#stockForm").on('submit', function(e){

            e.preventDefault();

            $.ajax({
                url:"{{ url('stock') }}",
                method:"POST",
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    // console.log("printing data");
                    // console.log(data);
                    $('#stockModal').modal('hide');
                    swal("Information", data.message);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });

        })

        // // edit product
        // $('body').on('click', '.editProduct', function () {
        //     var product_id = $(this).data('id');
        //     $.get("{{ url('product') }}" + '/' + product_id + '/edit', function (data) {
        //         $('#product_image').removeAttr("required");
        //         $('#modelHeading').html("Edit Product");
        //         $('#saveBtn').html('Update');
        //         $('#ajaxModel').modal('show');
        //         $('#product_id').val(data.product_id);
        //         $('#name').val(data.product_name);
        //         $('#description').val(data.product_description);

        //         variation_data = data.variation_data;

        //         console.log("printing responsed data");
        //         console.log(variation_data);

        //         // //disable the input for size
        //         // $("input[name='size']").attr("disabled", "disabled");
        //         // $("input[name='size']").attr("placeholder", "Click 'Variation' button to update variations");

        //         // //disable the input for flavor
        //         // $("input[name='flavor']").attr("disabled", "disabled");
        //         // $("input[name='flavor']").attr("placeholder", "Click 'Variation' button to update variations");
        //     })
        // });

        // delete product
        $('body').on('click', '.deleteProduct', function () {
            var product_id = $(this).data("id");
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
                        url: "{{ url('product') }}" + '/' + product_id,
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

    /* ----------------- size and flavor functionalites -------------------*/

    let cSize = "<?php echo $variation->size ?>".split(",");
    let cFlavor = "<?php echo $variation->flavor ?>".split(",");

    // let ccSize = variation_data[0].size.split(",");
    // let ccFlavor = variation_data[0].flavor.split(",");

    // console.log("printing variation_data");
    // console.log(variation_data);

    (function( $ ){
        $.fn.Size = function() {
          return this.each(function() {
            $list = $('<ul class="list-group list-group-flush" />');

            for(let i=cSize.length;i--;){
              if(!cSize[i]) continue;
              $list.append($('<li class="multipleInput-size"><span> '+ cSize[i] +'</span></li>')
                .append($('<a href="#" class="multipleInput-close" title="Remove">x</a>')
                  .click(function(e) {
                    $(this).parent().remove();
                    e.preventDefault();
                  })
                )
              );
            }

            // input
            var $input = $('<input name="size" class="form-control" placeholder="Press semicolon (;) to add sizes" />').keyup(function(event) {

              if(event.which == 186) {
                // key press is space or comma
                var val = $(this).val().slice(0, -1); // remove space/comma from value

                // append to list of emails with remove button
                $list.append($('<li class="list-group-item multipleInput-size"><span> ' + val + '</span></li>')
                  .append($('<a href="#" class="multipleInput-close" title="Remove">x</a>')
                    .click(function(e) {
                      $(this).parent().remove();
                      e.preventDefault();
                    })
                  )
                );

                $(this).attr('placeholder', '');
                // empty input
                $(this).val('');
              }
            });

            // container div
            var $container = $('<div class="multipleInput-container"  id="container-size"/>').click(function() {
              $input.focus();
            });

            // insert elements into DOM
            $container.append($list).append($input).insertAfter($(this));

            // add onsubmit handler to parent form to copy emails into original input as csv before submitting
            var $orig = $(this);
            $(this).closest('form').submit(function(e) {
              var sizes = new Array();
              $('.multipleInput-size span').each(function() {
                sizes.push($(this).html());
              });

              sizes.push($input.val());

              $orig.val(sizes.join());
              $('input[name="size"]').val(sizes.join());
            });

            return $(this).hide();
          });
        };

        $.fn.Flavor = function() {
          return this.each(function() {
            $list2 = $('<ul class="list-group list-group-flush" />');

            for(let i=cFlavor.length;i--;){
              if(!cFlavor[i]) continue;
              $list2.append($('<li class="multipleInput-flavor"><span> '+ cFlavor[i] +'</span></li>')
                .append($('<a href="#" class="multipleInput-close" title="Remove">x</a>')
                  .click(function(e) {
                    $(this).parent().remove();
                    e.preventDefault();
                  })
                )
              );
            }

            // input
            // var $input2 = $('<input name="flavor" class="form-control" placeholder="Press semicolon (;) to add flavors" onkeypress="return onlyLetters(event)" />').keyup(function(event) {

            //   if(event.which == 186) {
            //     // key press is space or comma
            //     var val = $(this).val().slice(0, -1); // remove space/comma from value

            //     // append to list of emails with remove button
            //     $list2.append($('<li class="list-group-item multipleInput-flavor"><span> ' + val + '</span></li>')
            //       .append($('<a href="#" class="multipleInput-close" title="Remove">x</a>')
            //         .click(function(e) {
            //           $(this).parent().remove();
            //           e.preventDefault();
            //         })
            //       )
            //     );

            //     $(this).attr('placeholder', '');
            //     // empty input
            //     $(this).val('');
            //   }
            // });

            // container div
            var $container = $('<div class="multipleInput-container" id="container-flavor" />').click(function() {
              $input2.focus();
            });

            // insert elements into DOM
            $container.append($list2).append($input2).insertAfter($(this));

            // add onsubmit handler to parent form to copy emails into original input as csv before submitting
            var $orig = $(this);

            $(this).closest('form').submit(function(e) {

              var flavors = new Array();
              $('.multipleInput-flavor span').each(function() {
                flavors.push($(this).html());
              });

              flavors.push($input2.val());

              $orig.val(flavors.join());
              $('input[name="flavor"]').val(flavors.join());
            });

            return $(this).hide();
          });
        };
    })( jQuery );

    $('#size').Size();
    $('#flavor').Flavor();

</script>
@endsection
