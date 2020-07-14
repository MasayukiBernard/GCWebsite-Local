@extends('layouts.app3')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
         <h3 class="font-weight-bold">Study Abroad Destinations</h3>
         <form method="post" action="/tempdestination" id="form3" enctype="multipart/form-data">
          @csrf
           @for($i = 0; $i < 3; $i++)
          
            <div class="form-group row pt-4">
                <label for="location[]" class="col-md-4 col-form-label text-md-left">{{ __($i+1) }}</label>
                <div class="col-md-8">
                    <select class="col-md-6 form-control @error('location[]') is-invalid @enderror" name="location[]">
                    <option value="" selected='selected'> - Select Destination - </option>
                         @if(isset($loc))
                         @foreach($loc as $ft)
                         <option value={{$ft->location}}> {{$ft->location}} </option>
                         @endforeach
                         @endif

                         </select>
                         <span class="col-md-9" style="color:red; font-weight:bold">
                         @if($errors->has('location'))
                              {{       $errors->first('location')}}
                         @endif
                         </span>
                </div>
            </div>
            <div class="form-group row">
               <label for="short_detail[]" class="col-md-4 col-form-label text-md-left">{{ __('Essay') }}</label>

               <div class="col-md-8">
               <textarea class="col-md-6 form-control @error('short_detail[]') is-invalid @enderror" rows="10" name="short_detail[]">
               </textarea>
               <span class="col-md-9" style="color:red; font-weight:bold">
                     @if($errors->has('short_detail[]'))
                     {{       $errors->first('short_detail[]')}}
                     @endif
               </span>
               </div>
            </div>
           @endfor
            
         </form>
           <div class="form-group row">
            	<div class="col-md-4 offset-md-4">
		           <div class="btn-group px-2" role="group" aria-label="Basic example">
		             <button onclick=location.href='/tempachievements' type="button px-2" class="btn btn-primary previous">&laquo; Previous</button>
		           </div>
                   <div class="btn-group px-2" role="group" aria-label="Basic example">
		             <button onclick=location.href='/tempemergency' type="button px-2" class="btn btn-primary next">Next &raquo;</button>
		           </div>
	            </div>
           </div>
        </div>
    </div>
</div>
@endsection
