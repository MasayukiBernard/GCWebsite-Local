@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card">
                <div class="card-header h4">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('sent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    Before you can proceed any further, please verify your email address by clicking the below link.
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Send Email Verification Link</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
