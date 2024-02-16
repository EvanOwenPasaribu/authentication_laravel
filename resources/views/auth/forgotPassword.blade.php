@extends('layouts.layout')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Lupa Password</div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card-body">
                    <form autocomplete="off" action="{{ route('password.send') }}" method="post">
                        @csrf
                        <input autocomplete="false" name="hidden" type="text" style="display:none;">
                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email
                                Address</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    autocomplete="false" id="email" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Kirim">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
