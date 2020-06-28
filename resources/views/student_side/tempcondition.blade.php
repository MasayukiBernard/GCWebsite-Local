@extends('layouts.app3')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
         <h3 class="font-weight-bold">Special Personal Information</h3>
         <form method="post" action="/tempcondition" id="form5" enctype="multipart/form-data">
          @csrf
 
           <div class="form-group row pt-4 px-2">
               <label for="med_condition" class="col-md-6 col-form-label text-md-left">{{ __('Do you have any disability or medical condition that host university should be aware of?') }}</label>

                <div class="col-md-6">
                    <input type="radio" name="med_condition" value=1>{{ __('YES') }}
                    <input type="radio" name="med_condition" value=0>{{ __('NO') }}
                    <span class="col-md-9" style="color:red; font-weight:bold">
                         @if($errors->has('med_condition'))
                              {{       $errors->first('med_condition')}}
                         @endif
                    </span>
                </div>
           </div>
           <div class="form-group row px-2">
                <label for="allergy" class="col-md-6 col-form-label text-md-left">{{ __('Do you have any allergy?') }}</label>
                <div class="col-md-6">
                    <input type="radio" name="allergy" value=1>{{ __('YES') }}
                    <input type="radio" name="allergy" value=0>{{ __('NO') }}
                    <span class="col-md-9" style="color:red; font-weight:bold">
                         @if($errors->has('allergy'))
                              {{       $errors->first('allergy')}}
                         @endif
                    </span>
                </div>
           </div>
           <div class="form-group row px-2">
                <label for="special_diet" class="col-md-6 col-form-label text-md-left">{{ __('Do you have any special dietary requirement(e.g. vegetarian food/halal food only?') }}</label>
                <div class="col-md-6">
                    <input type="radio" name="special_diet" value=1>{{ __('YES') }}
                    <input type="radio" name="special_diet" value=0>{{ __('NO') }}
                         <span class="col-md-9" style="color:red; font-weight:bold">
                         @if($errors->has('special_diet'))
                              {{       $errors->first('special_diet')}}
                         @endif
                         </span>
                </div>
           </div>
           <div class="form-group row px-2">
                <label for="convicted_crime" class="col-md-6 col-form-label text-md-left">{{ __('Have you ever been convicted of a crime offense?') }}</label>
                <div class="col-md-6">
                    <input type="radio" name="convicted_crime" value=1>{{ __('YES') }}
                    <input type="radio" name="convicted_crime" value=0>{{ __('NO') }}
                         <span class="col-md-9" style="color:red; font-weight:bold">
                         @if($errors->has('convicted_crime'))
                              {{       $errors->first('convicted_crime')}}
                         @endif
                         </span>
                </div>
           </div>
           <div class="form-group row px-2">
                <label for="test_type" class="col-md-6 col-form-label text-md-left">{{ __('Do you foresee any other difficulty that may affect the completion of your study?') }}</label>
                <div class="col-md-6">
                    <input type="radio" name="future_diffs" value=1>{{ __('YES') }}
                    <input type="radio" name="future_diffs" value=0>{{ __('NO') }}
                         <span class="col-md-9" style="color:red; font-weight:bold">
                         @if($errors->has('future_diffs'))
                              {{       $errors->first('future_diffs')}}
                         @endif
                         </span>
                </div>
           </div>
           <div class="form-group row px-2">
               <label for="reasons" class="col-md-6 col-form-label text-md-left">{{ __('Reason') }}</label>

               <div class="col-md-6">
               <textarea class="col-md-9 form-control @error('reasons') is-invalid @enderror" rows="16" name="reasons">
               </textarea>
               <span class="col-md-9" style="color:red; font-weight:bold">
                     @if($errors->has('reasons'))
                     {{       $errors->first('reasons')}}
                     @endif
               </span>
               </div>
           </div>
           <div class="form-group row">
                <span class="col-md-9" style="color:black">
                        Note: You no need to fill reason if you answer no for all special conditions
                </span>
           </div>
         </form>
           <div class="form-group row">
            	<div class="col-md-4 offset-md-4">
		           <div class="btn-group px-2" role="group" aria-label="Basic example">
		             <button onclick=location.href='/tempemergency' type="button px-2" class="btn btn-primary previous">&laquo; Previous</button>
		           </div>
                   <div class="btn-group px-2" role="group" aria-label="Basic example">
		             <button onclick=location.href='/tempdeclaration' type="button px-2" class="btn btn-primary next">Next &raquo;</button>
		           </div>
	            </div>
           </div>
        </div>
    </div>
</div>
@endsection
