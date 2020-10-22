@extends('layouts.app')
@inject('clients','App\User')

@section('content')
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <h4 class="center">Failed Delivery Emergency Text</h4>
        </div>
    </div>
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="order_number" class="col-sm-12 control-label">Order Number</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="order_number" name="order_number" placeholder="Enter Order Number" value="" maxlength="50" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="customer" class="col-sm-12 control-label">Customer</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="customer" name="customer">
                                <option value="99999" selected="selected">Choose a customer to assign</option>
                                @foreach($clients->where('user_role', 2)->orderBy('lname', 'asc')->get() as $client)
                                    @if(!empty($client))
                                        <option value="{{ $client->id }}" data-detail="{{ $client->fname.','.$client->lname.','.$client->contact_num.','.$client->address }}">{{ $client->lname.", ".$client->fname }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="template" class="col-sm-12 control-label">Template</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="template" name="template" disabled>
                                <option value="0" selected="selected">Choose message template</option>
                                <option value="temp_1">Template 1</option>
                                <option value="temp_2">Template 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-12 control-label">Message</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" id="message" name="message" style="height: 120px" disabled></textarea>
                        </div>
                    </div>
                    <button class="btn btn-info ml-auto" id="btnSubmitText" style="width: 100%;">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

        //ajax setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //set the customer into select2 dropdown
        $('#customer').select2();

        //when dropdown customer is blurred
        $("#order_number").blur(function(){

            //get the values
            const order = $("#order_number").val();
            const details = $("#customer option:selected").attr("data-detail") ? $("#customer option:selected").attr("data-detail") : "";
            const fname = details.split(",")[0];
            
            //check if the values are not empty
            if(order != "" && fname != ""){
                $("#template").removeAttr("disabled");    //remove disable
            }else{
                $("#template").attr("disabled", "disabled");    //enable disable
            }

        })

        //when dropdown customer is changed
        $("#customer").change(function(){

            //get the values
            const order = $("#order_number").val();
            const details = $("#customer option:selected").attr("data-detail") ? $("#customer option:selected").attr("data-detail") : "";
            const fname = details.split(",")[0];
            
            //check if the values are not empty
            if(order != "" && fname != ""){
                $("#template").removeAttr("disabled");    //remove disable
            }else{
                $("#template").attr("disabled", "disabled");    //enable disable
            }

        })

        //when dropdown template is changed
        $("#template").change(function(){

            //get the values
            const val = $("#template option:selected").val()
            const order = $("#order_number").val();
            const details = $("#customer option:selected").attr("data-detail") ? $("#customer option:selected").attr("data-detail") : "";
            const fname = details.split(",")[0];
            const lname = details.split(",")[1];
            const contact = details.split(",")[2];
            
            //if there is a value
            if(val == "temp_1" || val == "temp_2"){
                $("#message").removeAttr("disabled");    //remove disable

                //declare message output
                let message_output = "";

                if(val == "temp_1"){
                    message_output = `Hi ${lname}, ${fname}. We're sorry to inform you that your order # ${order} will not be delivered today due to [.........reason here................]. Please expect another text message from us to reschedule your order. Thanks for bearing with us.\n\nCreamline`
                }else if(val == "temp_2"){
                    message_output = `Good day ${lname}, ${fname}. This is from Creamline Support Team. We're sad to let you know that your order # ${order} has been cancelled today. The problem is [......reason here.......]. Please expect a text message from us to reschedule your order. We're sorry for the inconvenience.\n\nCreamline`
                }

                //return the output of the message
                $("#message").val(message_output)
            }else{
                $("#message").attr("disabled", "disabled");    //enable disable
            }

        })

        //when button submit is clicked
        $("#btnSubmitText").click(function(){
            //get the value of the contact number
            const details = $("#customer option:selected").attr("data-detail") ? $("#customer option:selected").attr("data-detail") : "";
            const contact = details.split(",")[2];
            const address = details.split(",")[3] ? details.split(",")[3] : "No address";
            const message = $("#message").val();
            const orderID = $("#order_number").val();

            if(contact == ""){
                return swal("Error", "Please input contact number");
            }

            if(message == ""){
                return swal("Error", "Please input a message")
            }

            //disable the button
            $("#btnSubmitText").attr("disabled", "disabled")

            //set params
            const params = {
                contact,
                address,
                orderID,
                message
            }

            $.ajax({
                data: params,
                url: "{{ url('emergency') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    //display a successful message
                    swal("Information", data.message).then()

                    //call the function for resetting the forms
                    defaultText();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        })

        //create a function that will set back the default
        function defaultText(){
            $("#order_number").val('');
            $('#customer option').prop('selected', function() { return this.defaultSelected; });
            $('#template option').prop('selected', function() { return this.defaultSelected; });
            $('#template').attr("disabled", "disabled");
            $("#message").val('');
            $('#message').attr("disabled", "disabled");
            $("#btnSubmitText").removeAttr("disabled");
        }

    })
</script>

@endsection
