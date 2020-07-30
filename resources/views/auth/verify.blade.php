@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
            <div class="card">
                <div class="card-header h4">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if(session('sent'))
                        <div id="notification_bar" class="row justify-content-center m-0 mb-2 text-light">
                            <div id="success_notif" class="col-md-12 bg-success rounded py-2 font-weight-bold h4 m-0">
                                <div class="row">
                                    <div class="col-11">
                                        {{ __('A verification link has been sent to your email address.') }}
                                    </div>
                                    <div class="col-1 text-right">
                                        <span id="close_notif" style="cursor: pointer;" onclick="close_notif();">X</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    Before you can proceed any further, please verify your email address by clicking the below link.<br>
                    <b>Please ensure your email address is correct in your profile page to prevent delays.</b><br>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Send Email Verification Link</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@if(session('sent'))
    @push('scripts')
        <script>
            function close_notif(){
                $('#notification_bar').fadeOut(500);
            }
        </script>
    @endpush
@endif