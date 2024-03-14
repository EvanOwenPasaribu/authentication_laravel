@extends('layouts.layout')

@section('content')

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @else
                        <div class="alert alert-success">
                            You are logged in!
                        </div>

                        @if (auth()->user() instanceof Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                            <div class="alert alert-danger">
                                Your email has not been verified. Please check your email for verification.
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        $( document ).ready(function() {
        console.log(Echo)
        let userId = {{ Auth::id() }};
        })
        
    </script>

@endsection
