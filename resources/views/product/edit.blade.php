@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 padding-2px">
            <div class="card">
                <div class="card-header">Edit Product</div>
                <div class="card-body">
                    <form id="productForm" enctype="multipart/form-data">
                        <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                        <div class="form-group">
                            <label for="name" class="col-sm-12 control-label">Product Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" maxlength="50" required="" value="{{ $product->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Product Description</label>
                            <div class="col-sm-12">
                                <input for="description" type="text" class="form-control" id="description" name="description" maxlength="255" required="" value="{{ $product->description }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Product Image</label>
                            <div class="col-sm-12">
                                <label class="new-avatar hidden"><span class="far fa-plus-square"></span>
                                    <input id="product_image" name="product_image[]" multiple type="file" class="text-center center-block file-upload"/>
                                </label>
                            </div>
                        </div>
                        <button class="btn btn-success full-width-button" id="btnUpdateProduct">Update</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3 padding-2px">
            <form id="variationForm" name="variationForm">
                <div class="card">
                    <div class="card-header">Edit Variation</div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <label class="col-sm-12 control-label" for="size">Product Size</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="size" maxlength="255">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label" for="flavor">Product Flavor</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="flavor" maxlength="255">
                            </div>
                        </div>
                        <button class="btn btn-success full-width-button" type="submit">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-5 padding-2px">
            <div class="card">
                <div class="card-header">Edit Price</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Size</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                //get the value for variation size and price
                                $var_size = explode(",", $variation->size);
                                $var_price = explode(",", $variation->price);
                                $size_count = count($var_price) - 1;
                                for($i = 0; $i < $size_count; $i++){
                                    echo "<tr>";
                                    echo    "<td>".$var_size[$i]."</td>";
                                    echo    "<td>&#8369;&nbsp;&nbsp;<input class='names' value='".$var_price[$i]."'</td>";
                                    echo "</tr>";
                                }
                             ?>
                        </tbody>
                    </table>
                    <button class="btn btn-success float-right full-width-button" id="btnUpdatePrice">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    $(function () {

        //ajax setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // create or update price
        $('#productForm').on('submit', function (e) {
            e.preventDefault();

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
                    swal("Information", data.message);
                    $('#productForm').trigger("reset");
                    // $("input[name='size']").val('');
                    // $("input[name='flavor']").val('');
                },
                error: function (data) {
                    console.log('Error:', data);
                    swal("Information", data);
                }
            });
        });

        // create or update price
        $('#variationForm').on('submit', function (e) {

            e.preventDefault();

            //get input values
            var product_id = $("#product_id").val();
            var size_values = $("input[name='size']").val();
            var flavor_values = $("input[name='flavor']").val();

            //declare parameters
            var params = {};

            //set parameters
            params.product_id = product_id;
            params.size = size_values.trim();
            params.flavor = flavor_values.trim();
            params.action = "update_size_flavor";

            $.ajax({
                data: params,
                url: "{{ url('product') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    // console.log("printing data");
                    // console.log(data);
                    swal("Information", data.message).then(data => {
                        if(data){
                            location.reload();
                        }
                    });
                },
                error: function (data) {
                    console.log('Error:', data);
                    swal("Information", data);
                }
            });
        });

        // create or update price
        $('#btnUpdatePrice').on('click', function () {

            //get the DOM values for price
            var price = $(".names");
            var price_values = '';

            //get the value of product id
            var product_id = $("#product_id").val();

            for(var i = 0; i < price.length; i++){
                price_values += $(price[i]).val()+",";
            }

            //clear all spaces and whitespaces
            price_values.replace(/\s/g,'');

            //declare parameters
            var params = {};

            //set parameters
            params.product_id = product_id;
            params.price = price_values;
            params.action = "update_price";

            $.ajax({
                data: params,
                url: "{{ url('product') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    // console.log("printing data");
                    // console.log(data);
                    swal("Information", data.message);
                },
                error: function (data) {
                    console.log('Error:', data);
                    swal("Information", data);
                }
            });
        });

    });

    

    /* ----------------- size and flavor functionalites -------------------*/

    let cSize = "<?php echo $variation->size ?>".split(",");
    let cFlavor = "<?php echo $variation->flavor ?>".split(",");

    // let ccSize = variation_data[0].size.split(",");
    // let ccFlavor = variation_data[0].flavor.split(",");

    (function( $ ){
        $.fn.Size = function() {
          return this.each(function() {
            $list = $('<ul class="list-group list-group-flush" />');

            for(let i=cSize.length;i--;){
              if(!cSize[i]) continue;
              $list.append($('<li class="multipleInput-size list-group-item"><span> '+ cSize[i] +'</span></li>')
                .append($('<a href="#" class="multipleInput-close" title="Remove">&nbsp;x</a>')
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
                  .append($('<a href="#" class="multipleInput-close" title="Remove">&nbsp;x</a>')
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

            // input
            var $input2 = $('<input name="flavor" class="form-control" value="'+cFlavor[0]+'" />')

            // container div
            var $container = $('<div class="multipleInput-container" id="container-flavor" />').click(function() {
              $input2.focus();
            });

            // insert elements into DOM
            $container.append($input2).insertAfter($(this));

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
