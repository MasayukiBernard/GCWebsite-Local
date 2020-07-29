@extends('student_side.csa_template.csa-template2')

@section('entity')
    Emergency Information
@endsection

@section('form-action')
{{route('student.csa-form.after-page5')}}
@endsection

@section('return-route')
    {{route('student.csa-form.csa-page4')}}
@endsection


@section('form-inputs')

        <div class="form-group row pt-4">
               <label for="name" class="col-md-4 col-form-label text-md-left">Name</label>

               <div class="col-md-8">
                   <input id="name" class="col-md-6 form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{old('name', $emergency->name)}}">
                    @error('name')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
               </div>
           </div>
           <div class="form-group row">
               <label for="relationship" class="col-md-4 col-form-label text-md-left">Relationship</label>

               <div class="col-md-8">
                    <input id="relationship" class="col-md-6 form-control @error('relationship') is-invalid @enderror" type="text" name="relationship" value="{{old('relationship', $emergency->relationship)}}">
                    @error('relationship')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
               </div>
           </div>
           <div class="form-group row">
               <label for="address" class="col-md-4 col-form-label text-md-left">Address</label>
               <div class="col-md-8">
               @if($emergency->address != null)
               <textarea class="col-md-6 form-control @error('address') is-invalid @enderror" rows="3" name="address" >{{$emergency->address}}</textarea>
               @else
               <textarea class="col-md-6 form-control @error('address') is-invalid @enderror" rows="3" name="address" ></textarea>
               @endif
                    @error('address')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
           </div>
           <div class="form-group row">
               <label for="telp_num" class="col-md-4 col-form-label text-md-left">Telephone Number</label>
               <div class="col-md-8">
                   <input id="telp_num" class="col-md-6 form-control @error('telp_num') is-invalid @enderror" type="text" name="telp_num" value="{{old('telp_num', $emergency->telp_num)}}" >
                    @error('telp_num')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
               </div>
           </div>
           <div class="form-group row">
               <label for="mobile" class="col-md-4 col-form-label text-md-left">Mobile Phone</label>

               <div class="col-md-8">
                   <input id="mobilenum" class="col-md-6 form-control @error('mobilenum') is-invalid @enderror" type="text" name="mobilenum" value="{{old('mobilenum', $emergency->mobile)}}">
                    @error('mobilenum')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
               </div>
           </div>
           <div class="form-group row">
               <label for="email" class="col-md-4 col-form-label text-md-left">E-mail</label>

               <div class="col-md-8">
                   <input id="email" class="col-md-6 form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{old('email', $emergency->email)}}" >
                    @error('email')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
               </div>
           </div>
           <div class="form-group row">
                <span class="col-md-9" style="color:black">
                        Note: A person to contact in a case of emergency
                </span>
           </div>

@endsection

@section('confirm-value')
Next
@endsection