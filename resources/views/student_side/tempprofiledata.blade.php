@extends('layouts.app3')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <!--<div class="col md-1"></div>-->
        <div class="col-md-12">
         <h3 class="font-weight-bold">Your Personal Details</h3>
         <form method="post" action="/tempprofiledata/{{Auth::user()->id}}" enctype="multipart/form-data">
          @csrf
          <div class="form-group row pt-4">
               <label for="name" class="col-md-4 col-form-label text-md-left">{{ __('Name') }}</label>

               <div class="col-md-8">
                   @if(Auth::check())
                   <input id="name" class="col-md-6 form-control @error('name') is-invalid @enderror" type="text" name="name" value={{Session::get('name')}} autofocus>
                   @else
                   <input id="name" class="col-md-6 form-control @error('name') is-invalid @enderror" type="text" name="name" value="name" autofocus>
                   @endif
                   <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('name'))
                           {{       $errors->first('name')}}
                        @endif
                   </span>
               </div>
          </div>
          <div class="form-group row">
               <label for="nim" class="col-md-4 col-form-label text-md-left">{{ __('NIM') }}</label>

               <div class="col-md-8">
                   @if(Auth::check())
                   <label for="nim" class="col-md-4 col-form-label text-md-left">{{Session::get('nim')}}</label>
                   @else
                   <label for="nim" class="col-md-4 col-form-label text-md-left">2X01XXXXXX</label>
                   @endif
               </div>
          </div>
          <div class="form-group row">
               <label for="picture_path" class="col-md-4 col-form-label text-md-left">{{ __('Profile Picture') }}</label>

               <div class="col-md-8">
                   <input id="picture_path" class="col-md-6 form-control @error('picture_path') is-invalid @enderror" type="file" name="picture_path" accept="image/*">
                   <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('picture_path'))
                           {{       $errors->first('picture_path')}}
                        @endif
                   </span>
               </div>
          </div>
          <div class="form-group row">
                <label for="gender" class="col-md-4 col-form-label text-md-left">{{ __('Gender') }}</label>
                <div class="col-md-8">
                    <select class="col-md-6 form-control @error('gender') is-invalid @enderror" name="gender">
                    <option value="" selected='selected'> - Select - </option>
                         
                         <option value="M"> Male </option>
                         <option value="F"> Female </option>

                         </select>
                         <span class="col-md-9" style="color:red; font-weight:bold">
                         @if($errors->has('gender'))
                              {{       $errors->first('gender')}}
                         @endif
                         </span>
                </div>
          </div>
          <div class="form-group row">
               <label for="place_birth" class="col-md-4 col-form-label text-md-left">{{ __('Place of Birth') }}</label>

               <div class="col-md-8">
                   <input id="place_birth" class="col-md-6 form-control @error('place_birth') is-invalid @enderror" type="text" name="place_birth" autofocus>
                   <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('place_birth'))
                           {{       $errors->first('place_birth')}}
                        @endif
                   </span>
               </div>
          </div>
          <div class="form-group row">
               <label for="date_birth" class="col-md-4 col-form-label text-md-left">{{ __('Date of Birth') }}</label>

               <div class="col-md-8">
                   <input id="date_birth" class="col-md-6 form-control @error('date_birth') is-invalid @enderror" type="date" name="date_birth" autofocus>
                   <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('date_birth'))
                           {{       $errors->first('date_birth')}}
                        @endif
                   </span>
               </div>
          </div>
          <div class="form-group row">
               <label for="nationality" class="col-md-4 col-form-label text-md-left">{{ __('Nationality') }}</label>

               <div class="col-md-8">
                   <input id="nationality" class="col-md-6 form-control @error('nationality') is-invalid @enderror" type="text" name="nationality" autofocus>
                   <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('nationality'))
                           {{       $errors->first('nationality')}}
                        @endif
                   </span>
               </div>
          </div>
          <div class="form-group row">
               <label for="email" class="col-md-4 col-form-label text-md-left">{{ __('Email') }}</label>

               <div class="col-md-8">
                   @if(Auth::check())
                   <input id="email" class="col-md-6 form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{Session::get('email')}}" autofocus>
                   @else
                   <input id="email" class="col-md-6 form-control @error('email') is-invalid @enderror" type="email" name="email" autofocus>
                   @endif
                   <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('email'))
                           {{       $errors->first('email')}}
                        @endif
                   </span>
               </div>
          </div>
          <div class="form-group row">
               <label for="mobile" class="col-md-4 col-form-label text-md-left">{{ __('Mobile Phone') }}</label>

               <div class="col-md-8">
                   <input id="mobile" class="col-md-6 form-control @error('mobile') is-invalid @enderror" type="text" name="mobile" autofocus>
                   <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('mobile'))
                           {{       $errors->first('mobile')}}
                        @endif
                        Example:081290089999
                   </span>
               </div>
          </div>
          <div class="form-group row">
               <label for="telp_num" class="col-md-4 col-form-label text-md-left">{{ __('Telephone Number') }}</label>

               <div class="col-md-8">
                   <input id="telp_num" class="col-md-6 form-control @error('telp_num') is-invalid @enderror" type="text" name="telp_num" autofocus>
                   <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('telp_num'))
                           {{       $errors->first('telp_num')}}
                        @endif
                        Example:4589699
                   </span>
               </div>
          </div>
          <div class="form-group row">
               <label for="address" class="col-md-4 col-form-label text-md-left">{{ __('Address') }}</label>

               <div class="col-md-8">
               <textarea class="col-md-6 form-control @error('address') is-invalid @enderror" rows="3" name="address">
               </textarea>
               <span class="col-md-9" style="color:red; font-weight:bold">
                     @if($errors->has('address'))
                     {{       $errors->first('address')}}
                     @endif
               </span>
               </div>
          </div>
          <div class="form-group row">
                <label for="flazz_card_proof_path" class="col-md-4 col-form-label text-md-left">{{ __('Binusian ID Picture Attachment') }}</label>
                <div class="col-md-8">
                     <input id="flazz_card_proof_path" class="col-md-6 form-control @error('flazz_card_proof_path') is-invalid @enderror" type="file" name="flazz_card_proof_path">
                     <span class="col-md-9" style="color:red; font-weight:bold">
                          @if($errors->has('flazz_card_proof_path'))
                             {{       $errors->first('flazz_card_proof_path')}}
                          @endif
                     </span>
                </div>
          </div>
          <div class="form-group row">
                <label for="id_card_picture_path" class="col-md-4 col-form-label text-md-left">{{ __('National ID Picture Attachment') }}</label>
                <div class="col-md-8">
                     <input id="id_card_picture_path" class="col-md-6 form-control @error('id_card_picture_path') is-invalid @enderror" type="file" name="id_card_picture_path">
                     <span class="col-md-9" style="color:red; font-weight:bold">
                          @if($errors->has('id_card_picture_path'))
                             {{       $errors->first('id_card_picture_path')}}
                          @endif
                     </span>
                </div>
          </div>

          <div class="form-group row">
            	<div class="col-md-4 offset-md-4">
		           <div class="btn-group px-2" role="group" aria-label="Basic example">
		             <button type="button px-2" class="btn btn-primary">{{ __('Back') }}</button>
		           </div>
                   <div class="btn-group px-2" role="group" aria-label="Basic example">
		             <button type="button px-2" class="btn btn-primary">{{ __('Insert') }}</button>
		           </div>
                   <!-- ganti jadi submit-->
	            </div>
          </div>
         </form>
        </div>
        <!--<div class="col md-1"></div>-->
    </div>
</div>
@endsection
