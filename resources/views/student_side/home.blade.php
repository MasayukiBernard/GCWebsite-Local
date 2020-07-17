@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (isset($user_status))
                        <div class="alert alert-success" role="alert">
                            {{$user_status}}
                        </div>
                    @endif

                    You are logged in as a Student!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
