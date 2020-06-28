@extends('layouts.app4')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
         <h3 class="font-weight-bold">Emergency Information</h3>
         <form method="post" action="/tempemergency" id="form4" enctype="multipart/form-data">
          @csrf
           <div class="form-group row pt-4">
               <label for="name" class="col-md-4 col-form-label text-md-left">{{ __('Name') }}</label>

               <div class="col-md-8">
                   <input id="name" class="col-md-6 form-control @error('name') is-invalid @enderror" type="text" name="name" autofocus>
                   <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('name'))
                           {{       $errors->first('name')}}
                        @endif
                   </span>
               </div>
           </div>
           <div class="form-group row">
               <label for="relationship" class="col-md-4 col-form-label text-md-left">{{ __('Relationship') }}</label>

               <div class="col-md-8">
                    <input id="relationship" class="col-md-6 form-control @error('relationship') is-invalid @enderror" type="text" name="relationship" autofocus>
                    <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('relationship'))
                           {{       $errors->first('Relationship')}}
                        @endif
                        Example:Father,Mother,Grandfather,Grandmother
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
               <label for="email" class="col-md-4 col-form-label text-md-left">{{ __('E-mail') }}</label>

               <div class="col-md-8">
                   <input id="email" class="col-md-6 form-control @error('email') is-invalid @enderror" type="email" name="email" autofocus>
                   <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('email'))
                           {{       $errors->first('email')}}
                        @endif
                   </span>
               </div>
           </div>
           <div class="form-group row">
                <span class="col-md-9" style="color:black">
                        Note: A person to contact in a case of emergency
                </span>
           </div>
         </form>
           <div class="form-group row">
            	<div class="col-md-4 offset-md-4">
		           <div class="btn-group px-2" role="group" aria-label="Basic example">
		             <button onclick=location.href='/tempdestination' type="button px-2" class="btn btn-primary previous">&laquo; Previous</button>
		           </div>
                   <div class="btn-group px-2" role="group" aria-label="Basic example">
		             <button onclick=location.href='/tempcondition' type="button px-2" class="btn btn-primary next">Next &raquo;</button>
		           </div>
	            </div>
           </div>
        </div>
    </div>
</div>

@endsection
