@extends('student_side.csa_template.csa-template')

@section('entity')
    Personal Infromation
@endsection

@section('form-action')
{{route('student.csa_form.csa-page1')}}
@endsection

@section('form-inputs')

    <div class="form-group row pt-4">
        <label for="name" class="col-md-4 col-form-label text-md-left">Name</label>
        <div class="col-md-8">
            <input id="name" class="col-md-6 form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ session()->get('personal_info.name') }}" >
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="nim" class="col-md-4 col-form-label text-md-left">Binusian ID</label>
        <div class="col-md-8">
        <input id="binusianID" class="col-md-6 form-control @error('binusianID') is-invalid @enderror" type="text" name="binusianID" value="{{ session()->get('personal_info.nim') }}" >
            @error('binusianID')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="picture_path" class="col-md-4 col-form-label text-md-left">Profile Picture</label>
            <div class="col-md-8">
                <input id="picture_path" class="col-md-6 form-control @error('picture_path') is-invalid @enderror" type="file" name="picture_path" accept="image/*">
                @error('picture_path')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
    </div>
    <div class="form-group row">
        <label for="gender" class="col-md-4 col-form-label text-md-left">Gender</label>
            <div class="col-md-8">
                <select class="col-md-6 form-control @error('gender') is-invalid @enderror" name="gender">
                    <option value="" selected='selected'> - Select - </option>    
                        <option value="M"> Male </option>
                        <option value="F"> Female </option>
                </select>
                @error('gender')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
    </div>
        <div class="form-group row">
            <label for="place_birth" class="col-md-4 col-form-label text-md-left">Place of Birth</label>
               <div class="col-md-8">
                   <input id="place_birth" class="col-md-6 form-control @error('place_birth') is-invalid @enderror" type="text" name="place_birth" value="{{ session()->get('personal_info.place_birth') }}" >
                    @error('place_birth')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
               </div>
          </div>
          <div class="form-group row">
               <label for="date_birth" class="col-md-4 col-form-label text-md-left">Date of Birth</label>
                    <div class="col-md-8">
                        <input id="date_birth" class="col-md-6 form-control @error('date_birth') is-invalid @enderror" type="date" name="date_birth" >
                        @error('date_birth')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror  
                    </div>
          </div>
          <div class="form-group row">
               <label for="nationality" class="col-md-4 col-form-label text-md-left">Nationality}</label>

               <div class="col-md-8">
                   <input id="nationality" class="col-md-6 form-control @error('nationality') is-invalid @enderror" type="text" name="nationality" value="{{ session()->get('personal_info.nationality') }}">
                    @error('nationality')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
               </div>
          </div>
          <div class="form-group row">
               <label for="email" class="col-md-4 col-form-label text-md-left">Email</label>
               <div class="col-md-8">
                   <input id="email" class="col-md-6 form-control @error('email') is-invalid @enderror" type="email" name="email"  value="{{ session()->get('personal_info.prefer_email') }}">
                    @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
               </div>
          </div>
          <div class="form-group row">
               <label for="mobile" class="col-md-4 col-form-label text-md-left">Mobile Phone</label>
               <div class="col-md-8">
                   <input id="mobilenum" class="col-md-6 form-control @error('mobilenum') is-invalid @enderror" type="text" name="mobilenum" value="{{ session()->get('personal_info.mobile') }}">
                    @error('mobilenum')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
               </div>
          </div>
          <div class="form-group row">
               <label for="telp_num" class="col-md-4 col-form-label text-md-left">Telephone Number</label>
               <div class="col-md-8">
                   <input id="telp_num" class="col-md-6 form-control @error('telp_num') is-invalid @enderror" type="text" name="telp_num" value="{{ session()->get('personal_info.telp_num') }}">
                    @error('telp_num')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
               </div>
          </div>
          <div class="form-group row">
               <label for="address" class="col-md-4 col-form-label text-md-left">Address</label>
               <div class="col-md-8">
               <textarea class="col-md-6 form-control @error('address') is-invalid @enderror" rows="3" name="address" value="{{ session()->get('personal_info.address') }}">
               </textarea>
                @error('address')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
               </div>
          </div>
          <div class="form-group row">
                <label for="flazz_card_proof_path" class="col-md-4 col-form-label text-md-left">Binusian Flash Picture Attachment</label>
                <div class="col-md-8">
                     <input id="flazz_card_proof_path" class="col-md-6 form-control @error('flazz_card_proof_path') is-invalid @enderror" type="file" name="flazz_card_proof_path">
                     @error('flazz_card_proof_path')
                     <div class="alert alert-danger">{{ $message }}</div>
                     @enderror
                </div>
          </div>
          <div class="form-group row">
                <label for="id_card_picture_path" class="col-md-4 col-form-label text-md-left">National ID Picture Attachment</label>
                <div class="col-md-8">
                     <input id="id_card_picture_path" class="col-md-6 form-control @error('id_card_picture_path') is-invalid @enderror" type="file" name="id_card_picture_path">
                     @error('place_birth')
                     <div class="alert alert-danger">{{ $message }}</div>
                     @enderror
                </div>
          </div>

          <div class="form-group row">
            	<div class="col-md-4 offset-md-4">
		           <!-- <div class="btn-group px-2" role="group" aria-label="Basic example">
		             <button type="button px-2" class="btn btn-primary">Back</button>
		           </div> -->
                   <div class="btn-group px-2" role="group" aria-label="Basic example">
		             <button type="button px-2" class="btn btn-primary" href="{{route('student.csa_form.csa-page1')}}">Next</button>
		           </div>
                   <!-- ganti jadi submit-->
	            </div>
          </div>
@endsection
