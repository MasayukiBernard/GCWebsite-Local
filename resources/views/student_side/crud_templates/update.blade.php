@extends('layouts.app2')

@section('title')
    Edit @yield('entity')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div id="notification_bar" class="row justify-content-center m-0 mb-2 text-danger">
                    @isset($warning)
                        <div id="warning_notif" class="col-md-12 bg-warning rounded py-2 font-weight-bold h4 m-0">
                            <div class="row">
                                <div class="col-11">
                                    {{$warning}}
                                </div>
                                <div class="col-1 text-right">
                                    <span id="close_notif" style="cursor: pointer;" onclick="close_notif();">X</span>
                                </div>
                            </div>
                        </div>
                    @endisset
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header h2">Old @yield('entity') data</div>
                    <div class="card-body">
                        @yield('old-data')
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header h2">Edit @yield('entity') data</div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="@yield('form-action')">
                            @csrf
                            @yield('form-inputs')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function close_notif(){
            $('#notification_bar').fadeOut(500);
        }
    </script>
@endpush