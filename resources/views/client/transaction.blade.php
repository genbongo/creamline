@extends('layouts.app')
@inject('clients','App\User')
@inject('stores','App\Store')

@section('content')
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <h4 class="center">Transaction Details</h4>
            <button class="btn btn-info ml-auto" id="btnSubmit">Submit</button>
        </div>
    </div>
    <br>

    <div class="card">
        <div class="card-header">
            Customer Information
        </div>
        <div class="card-body">
            @if(Auth::user()->user_role == 99)
                <div class="row">
                    <div class="col-md-6">
                        <label for="select_customer" class="control-label">Assign Customer:</label>
                        <select class="form-control" id="select_customer">
                            <option value="99999">Choose a customer to assign</option>
                            @foreach($clients->where('user_role', 2)->orderBy('lname', 'asc')->get() as $client)
                                @if(!empty($client))
                                    <option value="{{ $client->id }}" data-detail="{{ $client->fname.','.$client->mname.','.$client->lname.','.$client->address.','.$client->contact_num.','.$client->email }}">{{ $client->lname.", ".$client->fname }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="radio_replacement" class="control-label">For replacement:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radio_replacement" id="radio_replacement_yes" value="1" checked>
                            <label class="form-check-label" for="radio_replacement_yes">
                            Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radio_replacement" id="radio_replacement_no" value="0">
                            <label class="form-check-label" for="radio_replacement_no">
                            No
                            </label>
                        </div>
                    </div>
                </div><br>

            @endif

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fname" class="col-sm-12 control-label">First Name</label>
                        <div class="col-sm-12">
                            <input type="hidden" name="id" id="id" value="{{ Auth::user()->id }}" >
                            <input type="text" value="{{ Auth::user()->fname }}" class="form-control" id="fname" name="fname"value="" maxlength="50" disabled="" readonly="" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="mname" class="col-sm-12 control-label">Middle Name</label>
                        <div class="col-sm-12">
                            <input type="text" value="{{ Auth::user()->mname }}" class="form-control" id="mname" name="mname"value="" maxlength="50" disabled="" readonly="" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="lname" class="col-sm-12 control-label">Last Name</label>
                        <div class="col-sm-12">
                            <input type="text" value="{{ Auth::user()->lname }}" class="form-control" id="lname" name="lname"value="" maxlength="50" disabled="" readonly="" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="address" class="col-sm-12 control-label">Address</label>
                        <div class="col-sm-12">
                            <input type="text" value="{{ Auth::user()->address }}" class="form-control" id="address" name="address"value="" maxlength="50" disabled="" readonly="" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="contact" class="col-sm-12 control-label">Contact Number</label>
                        <div class="col-sm-12">
                            <input type="text" value="{{ Auth::user()->contact_num }}" class="form-control" id="contact" name="contact"value="" maxlength="50" disabled="" readonly="" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email" class="col-sm-12 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="text" value="{{ Auth::user()->email }}" class="form-control" id="email" name="email"value="" maxlength="50" disabled="" readonly="" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            Store Information
        </div>
        <div class="card-body">
            <label for="select_store" class="control-label">Store:</label>
            <select class="form-control" id="select_store">
                <option value="99999">Choose a store</option>

                @if( auth()->user()->user_role == 2)
                    @foreach( auth()->user()->stores as $store)
                        <option value="{{ $store->id }}">{{ $store->store_address.' - '.$store->store_name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    @if(auth()->user()->user_role == 99)
        <div class="card mt-4">
            <div class="card-header">
                Delivery Date
            </div>

            <div class="card-body">
                <input type="date" class="form-control" name="delivery_date" id="delivery_date">
            </div>
        </div>
    @endif

    <script type="text/javascript">
        $(() => {

            //ajax setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //if dropdown is changed
            $("#select_customer").change(() => {
                //get the dom values
                const details = $("#select_customer option:selected").attr("data-detail");

                //get all the values
                const id = $("#select_customer option:selected").val();
                const fname = details.split(",")[0];
                const mname = details.split(",")[1];
                const lname = details.split(",")[2];
                const address = details.split(",")[3];
                const contact = details.split(",")[4];
                const email = details.split(",")[5];

                //set the values
                $("#id").val(id);
                $("#fname").val(fname);
                $("#mname").val(mname);
                $("#lname").val(lname);
                $("#address").val(address);
                $("#contact").val(contact);
                $("#email").val(email);


                $.get(`/client/${id}/stores/json`, function (stores) {
                    //get user's stores
                    var storeInput = '';

                    stores.map(store => {
                      storeInput += '<option value="'+store.id+'">'+store.store_name+'</option>'
                    })
                    //embed it to DOM
                    $("#select_store").empty().append(storeInput)
                })
            });

            // create or update cart
            $('#btnSubmit').click(function (e) {

                //if admin and there is no customer selected
                if($("#select_customer").length && $("#select_customer option:selected").val() == "99999"){
                    return swal("Error", "Please select a customer first!")
                }

                //if there is no store selected then prompt the user
                if($("#select_store option:selected").val() == "99999"){
                    return swal("Error", "Please select a store!")
                }

                swal({
                    title: "Are you sure you want to proceed?",
                    icon: "info",
                    buttons: true,
                    dangerMode: false,
                })
                .then((isTrue) => {
                    if (isTrue) {

                        //get the customer id and store id
                        const customer_id = $("#id").val();
                        const current_id = {{Auth::user()->id}};
                        const store_id = $("#select_store option:selected").val();
                        const is_replacement = $('input[name="radio_replacement"]').length ? $('input[name="radio_replacement"]:checked').val() : 0;

                        const isAdmin = $('input[name="radio_replacement"]').length ? true : false;

                        //set params
                        var params = {};

                        params.client_id = customer_id;
                        params.current_id = current_id;
                        params.store_id = store_id;
                        params.is_replacement = is_replacement;
                        params.delivery_date = $('#delivery_date').val();

                        $.ajax({
                            data: params,
                            url: "{{ url('transaction') }}",
                            type: "POST",
                            dataType: 'json',
                            success: function (data) {

                                //display a successful message
                                swal("Information", data.message).then(function() {
                                    if(isAdmin === true){
                                        window.location = "order#order-tab-tran-his";
                                    }else{
                                        window.location = "info";
                                    }
                                })
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });
                    }
                });
            });
        })
    </script>
    
</div>

@endsection