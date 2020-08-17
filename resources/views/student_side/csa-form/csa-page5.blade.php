@extends('student_side.csa_template.csa-template5')

@section('entity')
    Emergency Information &mdash; CSA Application Form Page 5
@endsection

@section('form-action')
{{route('student.csa-form.after-page5')}}
@endsection

@section('form-inputs')
    <hr>
    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-left font-weight-bold">Name</label>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-1 pr-0">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="male" name="gender" class="custom-control-input" value="M" onclick="changeUpdate();" {{old('gender') != null ? (old('gender') == 'M' ? 'checked' : '') : (isset($emergency) ? ($emergency->gender == 'M' ? 'checked' : '') : '')}}>
                        <label class="custom-control-label" for="male">Mr.</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="female" name="gender" class="custom-control-input" value="F" onclick="changeUpdate();" {{old('gender') != null ? (old('gender') == 'F' ? 'checked' : '') : (isset($emergency) ? ($emergency->gender == 'F' ? 'checked' : '') : '')}}>
                        <label class="custom-control-label" for="female">Mrs.</label>
                    </div>
                </div>
                <div class="col-md-11 mt-1 pl-4">
                    <input id="name" class="col-md-12 form-control @error('name') is-invalid @enderror" type="text" name="name" onkeypress="changeUpdate();" value="{{old('name', isset($emergency) ? $emergency->name : '')}}" autocomplete="off">  
                </div>
            </div>
            @error('gender')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="relationship" class="col-md-4 col-form-label text-md-left font-weight-bold">Relationship</label>

        <div class="col-md-8">
            <input id="relationship" class="col-md-12 form-control @error('relationship') is-invalid @enderror" type="text" name="relationship" onkeypress="changeUpdate();" value="{{old('relationship', isset($emergency) ? $emergency->relationship : '')}}" autocomplete="off">
            @error('relationship')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="address" class="col-md-4 col-form-label text-md-left font-weight-bold">Address</label>
        <div class="col-md-8">
            <textarea class="col-md-12 form-control @error('address') is-invalid @enderror" rows="3" style="resize: none;" name="address" onkeypress="changeUpdate();" autocomplete="off">{{old('address', isset($emergency) ? $emergency->address : '')}}</textarea>
            @error('address')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="telp_num" class="col-md-4 col-form-label text-md-left font-weight-bold">Telephone Number</label>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-1 pr-0">
                    <div class="mt-2">0</div>
                </div>
                <div class="col-md-11 px-0 ml-n3">
                    <input id="telp_num" class="col-md-12 form-control @error('telp-num') is-invalid @enderror" type="text" name="telp-num" onkeypress="changeUpdate();" value="{{old('telp-num', isset($emergency) ? $emergency->telp_num : '')}}" autocomplete="off">
                </div>
            </div>
            @error('telp-num')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="mobile" class="col-md-4 col-form-label text-md-left font-weight-bold">Mobile Phone</label>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-1 pr-0">
                    <div class="mt-2">0</div>
                </div>
                <div class="col-md-11 px-0 ml-n3">
                    <input id="mobile" class="col-md-12 form-control @error('mobile') is-invalid @enderror" type="text" name="mobile" onkeypress="changeUpdate();" value="{{old('mobile', isset($emergency) ? $emergency->mobile : '')}}" autocomplete="off">
                </div>
            </div>
            @error('mobile')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-left font-weight-bold">E-mail</label>
        <div class="col-md-8">
            <input id="email" class="col-md-12 form-control @error('email') is-invalid @enderror" type="email" name="email" onkeypress="changeUpdate();" value="{{old('email', isset($emergency) ? $emergency->email : '')}}" autocomplete="off">
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-md-12">
            <b>Note:</b><br>
            These data are the person to contact in a case of emergencies.
        </div>
    </div>
    <hr>
@endsection

@section('return-route')
{{route('student.csa-form.csa-page4')}}
@endsection

@section('confirm-value')
Update & Next &#x0226B;
@endsection

@section('next-value')
Next &#x0226B;
@endsection

@push('scripts')
    <script>
        function changeUpdate(){
            $('#next_btn').addClass('d-none');
            $('#submit_btn').removeClass('d-none');
        }
    </script>    
@endpush