@extends('student_side.csa_template.csa-template')

@section('entity')
    Emergency Information
@endsection

@section('form-action')
{{route('student.csa_form.csa-page6')}}
@endsection

@section('form-inputs')

<div class="form-group row pt-4 px-2">
               <label for="med_condition" class="col-md-6 col-form-label text-md-left">Do you have any disability or medical condition that host university should be aware of?</label>

                <div class="col-md-6">
                    <input type="radio" name="med_condition" value=1>{{ __('YES') }}
                    <input type="radio" name="med_condition" value=0>{{ __('NO') }}
                    @error('med_condition')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
           </div>
           <div class="form-group row px-2">
                <label for="allergy" class="col-md-6 col-form-label text-md-left">Do you have any allergy?</label>
                <div class="col-md-6">
                    <input type="radio" name="allergy" value=1>{{ __('YES') }}
                    <input type="radio" name="allergy" value=0>{{ __('NO') }}
                    @error('allergy')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
           </div>
           <div class="form-group row px-2">
                <label for="special_diet" class="col-md-6 col-form-label text-md-left">Do you have any special dietary requirement(e.g. vegetarian food/halal food only)? </label>
                <div class="col-md-6">
                    <input type="radio" name="special_diet" value=1>{{ __('YES') }}
                    <input type="radio" name="special_diet" value=0>{{ __('NO') }}
                    @error('special_diet')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
           </div>
           <div class="form-group row px-2">
                <label for="convicted_crime" class="col-md-6 col-form-label text-md-left">Have you ever been convicted of a crime offense?'</label>
                <div class="col-md-6">
                    <input type="radio" name="convicted_crime" value=1>{{ __('YES') }}
                    <input type="radio" name="convicted_crime" value=0>{{ __('NO') }}
                    @error('convicted_crime')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
           </div>
           <div class="form-group row px-2">
                <label for="test_type" class="col-md-6 col-form-label text-md-left">Do you foresee any other difficulty that may affect the completion of your study?</label>
                <div class="col-md-6">
                    <input type="radio" name="future_diffs" value=1>{{ __('YES') }}
                    <input type="radio" name="future_diffs" value=0>{{ __('NO') }}
                    @error('test_type')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
           </div>
           <div class="form-group row px-2">
               <label for="explanation" class="col-md-6 col-form-label text-md-left">Explanation</label>

               <div class="col-md-6">
               <textarea class="col-md-9 form-control @error('explanation') is-invalid @enderror" rows="10" name="explanation">
               </textarea>
               @error('explanation')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
               </div>
           </div>
           <div class="form-group row">
                <span class="col-md-9" style="color:black">
                        Note: You no need to fill reason if you answer no for all special conditions
                </span>
           </div>

@endsection

