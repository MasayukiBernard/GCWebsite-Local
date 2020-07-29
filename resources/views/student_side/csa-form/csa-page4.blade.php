@extends('student_side.csa_template.csa-template3')

@section('entity')
    Application Detail
@endsection

@section('form-action')
{{route('student.csa-form.after-page4')}}
@endsection

@section('return-route')
    {{route('student.csa-form.csa-page3')}}
@endsection

@section('form-inputs')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
          @csrf
           @for($i = 0; $i < 3; $i++)
          
            <div class="form-group row pt-4">
                <label for="location[]" class="col-md-4 col-form-label text-md-left">{{ __($i+1) }}</label>
                <div class="col-md-8">
                    <select class="col-md-6 form-control @error('location[]') is-invalid @enderror" name="location[]">
                    <option value="" selected='selected'> - Select Destination - </option>
                         @if(isset($partner))
                         @foreach($partner as $ft)
                         <option value={{$ft->name}}> {{$ft->name}} </option>
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
            
        </div>
    </div>
</div>
@endsection
