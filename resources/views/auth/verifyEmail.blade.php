@extends('layouts.layout')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Verification Email</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h5>Please Verification You Email</h5>

                    <form action="{{ route('verification.send') }}" method="post">
                        @csrf
                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Send Verification Again">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
