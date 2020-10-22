@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <p><h5>Succesfully purchased!</h5></p>
                    <p>Please wait for your purhased items to be approved by the ADMIN.</p>
                    <p>For more info, please check the details of your order by clicking <a href="{{ url('transaction_history') }}">here</a>.</p><br>
                    <a class="btn btn-success" href="{{ url('shop') }}">Shop more</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
