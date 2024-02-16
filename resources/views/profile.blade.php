@extends('layouts.layout')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Profile</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h5>{{ Auth::user()->name }}</h5>
                    <h5>{{ Auth::user()->email }}</h5>

                </div>
            </div>
        </div>
    </div>
@endsection
