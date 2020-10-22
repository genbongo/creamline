@inject('areas','App\Area')
@extends('layouts.app_default')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-4">{{ __('User Information') }}</div>
                        <div class="col-md-4">{{ __('Store') }}</div>
                        <div class="col-md-2">{{ __('Account') }}</div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="fname" class="col-md-5 col-form-label text-md-right">{{ __('First Name') }}</label>

                                    <div class="col-md-7">
                                        <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" required autocomplete="fname" autofocus>

                                        @error('fname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="mname" class="col-md-5 col-form-label text-md-right">{{ __('Middle Name') }}</label>

                                    <div class="col-md-7">
                                        <input id="mname" type="text" class="form-control @error('mname') is-invalid @enderror" name="mname" value="{{ old('mname') }}" required autocomplete="mname" autofocus>

                                        @error('mname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="lname" class="col-md-5 col-form-label text-md-right">{{ __('Last Name') }}</label>

                                    <div class="col-md-7">
                                        <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" required autocomplete="lname" autofocus>

                                        @error('lname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="address" class="col-md-5 col-form-label text-md-right">{{ __('Address') }}</label>

                                    <div class="col-md-7">
                                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address" autofocus>

                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="contact_num" class="col-md-5 col-form-label text-md-right">{{ __('Contact Number') }}</label>

                                    <div class="col-md-7">
                                        <input id="contact_num" type="number" placeholder="09xxxxxxxxx" class="form-control @error('contact_num') is-invalid @enderror" name="contact_num" value="{{ old('contact_num') }}" required autocomplete="contact_num" autofocus>

                                        @error('contact_num')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="area_id" class="col-md-5 col-form-label text-md-right">{{ __('Store Location') }}</label>

                                    <div class="col-md-7">
                                        <select class="form-control" id="area_id" name="area_id">
                                            @foreach($areas->all() as $area)
                                              <option value="{{ $area->id }}">{{ $area->area_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="store_name" class="col-md-5 col-form-label text-md-right">{{ __('Store Name') }}</label>

                                    <div class="col-md-7">
                                        <input id="store_name" type="store_name" class="form-control @error('store_name') is-invalid @enderror" name="store_name" value="{{ old('store_name') }}" required autocomplete="store_name">

                                        @error('store_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="store_address" class="col-md-5 col-form-label text-md-right">{{ __('Store Address') }}</label>

                                    <div class="col-md-7">
                                        <input id="store_address" type="store_address" class="form-control @error('store_address') is-invalid @enderror" name="store_address" value="{{ old('store_address') }}" required autocomplete="store_address">

                                        @error('store_address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="email" class="col-md-5 col-form-label text-md-right">{{ __('Email Address') }}</label>

                                    <div class="col-md-7">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-5 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-7">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-5 col-form-label text-md-right">{{ __('Confirm') }}</label>

                                    <div class="col-md-7">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary full-width-button">{{ __('Register') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
