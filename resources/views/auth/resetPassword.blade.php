@extends('layouts.layout')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Reset Password</div>
                <div class="card-body">
                    @if ($errors->has('status'))
                        <span class="text-danger">{{ $errors->first('status') }}</span>
                    @endif
                    <form action="{{ route('reset') }}" method="post">
                        @csrf
                        <input type="hidden" value="{{ $email }}" name="email">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                        <input type="hidden" value="{{ $token }}" name="token">
                        @if ($errors->has('token'))
                            <span class="text-danger">{{ $errors->first('token') }}</span>
                        @endif
                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="password_confirmation"
                                class="col-md-4 col-form-label text-md-end text-start">Confirm Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Reset">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
