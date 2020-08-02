@extends('student_side.csa_template.csa-template4')

@section('entity')
    Application Detail &mdash; CSA Application Form Page 4
@endsection

@section('form-action')
{{route('student.csa-form.after-page4')}}
@endsection

@section('form-inputs')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div>
                <a href="{{route('student.yearly-partners', ['academic_year_id' => $academic_year_id])}}" target="_blank">See detailed information of all available partners in selected academic year here!</a>
            </div>
            <div>
                <small>You have to atleast enter one (1) preferred university with your motivation to go there!</small>
            </div>
            @csrf
            <hr>
            @for($i = 0; $i < 3; $i++)
                <div class="form-group row pt-4">
                    <label for="preferred_uni_{{$i}}" class="col-md-4 col-form-label text-md-left font-weight-bold">Preferred Partner University #{{ __($i+1) }}</label>
                    <div class="col-md-8">
                        <select class="col-md-12 custom-select custom-select-lg @error('preferred-uni-' . $i) is-invalid @enderror" name="preferred-uni-{{$i}}" onchange="changeUpdate();">
                            <option value=""> - Select Destination - </option>
                            @foreach($yp_in_mjay as $yp)
                                <option value={{$yp->id}} {{old('preferred-uni-' . $i) != null ? (old('preferred-uni-' . $i) == $yp->id ? 'selected' : '') : (isset($choices[$i]) ? ($choices[$i]->yearly_partner_id == $yp->id ? 'selected' : '') : '')}}> {{$yp->name}} | {{$yp->location}} </option>
                            @endforeach
                        </select>
                        @error('preferred-uni-' . $i)
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="motivation_{{$i}}" class="col-md-4 col-form-label text-md-left  font-weight-bold">{{ __('Motivation #' . ($i+1)) }}</label>
                    <div class="col-md-8">
                        <textarea class="col-md-12 form-control @error('motivation-' . $i) is-invalid @enderror" rows="10" name="motivation-{{$i}}" onkeypress="changeUpdate();">{{old('motivation-' . $i, isset($choices[$i]) ? $choices[$i]->motivation : '')}}</textarea>
                        @error('motivation-' . $i)
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <hr>
            @endfor
        </div>
    </div>
</div>
@endsection

@section('return-route')
{{route('student.csa-form.csa-page3')}}
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