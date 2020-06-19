@extends('layouts.app2')

@section('title')
    Upload a batch of Students
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header h2">Add New Batch of Students</div>
                    <div class="card-body">
                        @isset($error)
                            <div class="bg-danger text-light p-2">
                                Input Data was Misformatted!!!
                            </div>
                        @endisset
                        <form method="POST" action="{{route('staff.student.create-batch-confirm')}}" enctype="multipart/form-data">
                            @csrf
                            Upload the filled template (.txt tab delimited file) down here to create a batch of students!!
                            <div class="custom-file mb-3">
                                <input type="file" onchange="changeLabel();" class="custom-file-input @error('batch-students') is-invalid @enderror" id="customFile" name="batch-students">
                                <label class="custom-file-label" id="customFileLabel" for="customFile">Choose file</label>
                            </div>
                            @error('batch-students')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <input type="submit" class="btn btn-success" value="Upload">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function changeLabel(){
        document.getElementById('customFileLabel').innerHTML = document.getElementById('customFile').files[0].name;
    }
</script>
    
@endpush