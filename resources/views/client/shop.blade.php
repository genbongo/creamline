@inject('prod','App\Product')
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5 class="text-center">Shop</h5>
            </div>
            <div class="card-body">
                <div class="row text-center text-lg-left">
                    @foreach($prod->all() as $product)
                        @if($product->is_deleted == 1)
                        <div class="col-lg-3 col-md-4 col-6 pointer div-prod item">
                            <span class="notify-badge">Sold Out</span>
                            <img class="img-fluid img-thumbnail card-img-top shop-img" style="height:200px" src="{{ asset('img/product').'/'.$product->product_image}}" alt="">
                            <div class="padding-all-10px">
                                <h5>{{ $product->name }}</h5>
                            </div>
                        </div>
                        @endif
                        @if($product->is_deleted == 0)
                        <div class="col-lg-3 col-md-4 col-6 pointer div-prod item" data-val="{{ $product->id }}">
                            <img class="img-fluid img-thumbnail card-img-top shop-img" style="height:200px" src="{{ asset('img/product').'/'.$product->product_image}}" alt="">
                            <div class="padding-all-10px">
                                <h5>{{ $product->name }}</h5>
                            </div>
                        </div>
                        @endif
                        
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- pre-order modal --}}
<div class="modal fade" id="preOrderModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pre Order</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card" style="width: 100%;">
                            <div class="card-body padding-all-10px">
                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                    <!-- indicator -->
                                  <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                  </ol>
                                  <!-- indicator -->
                                  <div class="carousel-inner" id="product_images">

                                  </div>
                                  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                  </a>
                                  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                  </a>
                                 </div>

                                <h5 class="card-title" id="div-modal-title">asdfadsf</h5>
                                <p class="card-text" id="div-modal-text">adsfadsf</p>
                            </div>
                            <div class="card-body padding-all-10px">
                                <p class="card-text">Stocks: <span id="div-stocks-qty">.....</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="size_id" class="col-md-12 col-form-label">Size:</label>
                            <div class="col-md-12">
                                <select class="form-control" id="size_id" name="size_id"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="flavor_id" class="col-md-12 col-form-label">Flavor:</label>
                            <div class="col-md-12">
                                <select class="form-control" id="flavor_id" name="flavor_id"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="quantity" class="col-md-12 col-form-label">Quantity:</label>
                            <div class="col-md-12">
                                <input 
                                    class="form-control" 
                                    type="number" 
                                    id="quantity" 
                                    name="quantity" 
                                    value="1"
                                />
                            </div>
                        </div>
                        <div class="form-group">
                            <div id="totalPrice"></div>
                            <button class="btn btn-success full-width-button" id="btnAddToCart">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){

        //ajax setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //declare local variables
        var prod_id = '';
        var prod_image = '';
        var prod_name = '';
        var prod_desc = '';
        var prod_stocks_qty = '';

        $('body').on('click', '.div-prod', function(){
            var current_id = $(this).attr("data-val");
            $.get("{{ url('edit_product') }}" + '/' + current_id, function (data) {

                console.log("printing data");
                console.log(data);

                //set local variables data
                prod_id = data.product.id;
                prod_name = data.product.name;
                prod_desc = data.product.description;
                prod_stocks_qty = data.stock.quantity;

                var name = data.product.product_image.split('.')
                var url  = "{{ asset('img/product') }}" +"/"+ data.product.product_image
                var jsx = `<div class="carousel-item active">
                    <img class="d-block w-100" src="${url}" alt="${name[0]}">
                  </div>`

                $('#product_images').append(jsx)

                {{ asset('img/product').'/'.$product->product_image}}

                data.product.images.map(image => {
                    var name = image.path.split('.')
                    var url  = "{{ asset('img/product') }}" +"/"+ image.path
                    var jsx = `<div class="carousel-item">
                        <img class="d-block w-100" src="${url}" alt="${name[0]}">
                      </div>`

                    $('#product_images').append(jsx)
                })

                $("#div-modal-title").html(data.product.name);

                //call the function that will populate the size dropdown
                populateSizeDropdown(data);

                //call the function that will populate the flavor dropdown
                populateFlavorDropdown(data);

                var price = $("#size_id option:selected").attr("data-price");
                $("#div-modal-text").html("&#8369; " + price + ".00");
                $("#div-stocks-qty").html(prod_stocks_qty);
                
                // $('#description').val(data.product_description);
                $('#preOrderModal').modal('show');
            });
        });

        //when size is changed
        $("#size_id").change(() =>{
            var price = $("#size_id option:selected").attr("data-price");
            var qty = $("#quantity").val();

            $("#div-modal-text").html("&#8369; " + price + ".00");
            $("#totalPrice").html("&#8369; " + price * qty + ".00");
        });

        //when the quantity event is blurred
        $("#quantity").blur(function(){
            var current_val = $("#quantity").val();
            if(current_val < 1){
                $("#quantity").val("1");
            }else{
                var price = $("#size_id option:selected").attr("data-price");
                const totalPrice = price * current_val;
                $("#totalPrice").html("&#8369; " + totalPrice + ".00");
            }

        });

        //when button add to cart is clicked
        $("#btnAddToCart").click(function(){

            swal({
                title: "Are you sure?",
                text: "It will be stored in your cart.",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((isTrue) => {
                if (isTrue) {

                    //get all the values
                    var size = $("#size_id option:selected").val();
                    var price = $("#size_id option:selected").attr("data-price");
                    var flavor = $("#flavor_id option:selected").val();
                    var quantity = $("#quantity").val();

                    //check if the current quantity selected is greater than the current stocks
                    if(quantity > prod_stocks_qty){
                        return swal("Error", "Sorry, this product is currently out of stocks!");
                    }

                    //declare a parameters to be stored in session
                    var params = {};

                    //set value to parameter
                    params.product_id = prod_id;
                    params.product_image = prod_image;
                    params.product_name = prod_name;
                    params.product_description = prod_desc;
                    params.size = size;
                    params.flavor = flavor;
                    params.quantity = quantity;
                    params.subtotal = price * quantity;

                    $.ajax({
                        type: "POST",
                        url: "{{ url('cart') }}",
                        data: params,
                        success: function (response) {
                            // console.log("printing response");
                            // console.log(response);

                            $('#preOrderModal').modal('hide');

                            swal("Information", response.message);
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });

        });

        //create a function that will populate the size dropdown
        function populateSizeDropdown(data){

            var variation_size = data.variation.size.split(",");
            var variation_price = data.variation.price.split(",");
            var output = '';

            $("#totalPrice").html("&#8369; " + variation_price[0] + ".00");

            for(var i = 0; i < variation_size.length; i++){
                output += '<option value="'+ variation_size[i] +'" data-price="'+ variation_price[i] +'">'+ variation_size[i] +'</option>';
            }

            $("#size_id").html(output);
        }

        //create a function that will populate the flavor dropdown
        function populateFlavorDropdown(data){

            var  variation_flavor = data.variation.flavor.split(",").filter(flavor => flavor != '');

            var output = '';

            for(var i = 0; i < variation_flavor.length; i++){
                output += '<option value="'+ variation_flavor[i] +'">'+ variation_flavor[i] +'</option>';
            }

            $("#flavor_id").html(output);
        }

    });
</script>

@endsection
