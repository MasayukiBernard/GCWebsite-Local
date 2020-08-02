@extends('student_side.csa_template.csa-template6')

@section('entity')
    Medical, Dietary, and Other Information &mdash; CSA Application Form Page 6
@endsection

@section('form-action')
{{route('student.csa-form.after-page6')}}
@endsection

@section('form-inputs')
    <hr>
    <div class="form-group row px-2">
        <label for="med_condition" class="col-md-10 col-form-label text-md-left mt-1 font-weight-bold">Do you have any disability or medical condition that host university should be aware of?</label>
        <div class="col-md-2">
            <div class="custom-control custom-radio">
                <input type="radio" id="med_con_yes" name="med-condition" class="custom-control-input" value="1" onclick="changeUpdate();" {{old('med-condition') != null ? (old('med-condition') == '1' ? 'checked' : '') : (isset($condition) ? ($condition->med_condition == '1' ? 'checked' : '') : '')}}>
                <label class="custom-control-label" for="med_con_yes">YES</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="med_con_no" name="med-condition" class="custom-control-input" value="0" onclick="changeUpdate();" {{old('med-condition') != null ? (old('med-condition') == '0' ? 'checked' : '') : (isset($condition) ? ($condition->med_condition == '0' ? 'checked' : '') : '')}}>
                <label class="custom-control-label" for="med_con_no">NO</label>
            </div>
        </div>
    </div>
    @error('med-condition')
        <div class="row px-3">
            <div class="alert alert-danger col-md-12">{{ $message }}</div>
        </div>
    @enderror
    <hr>
    <div class="form-group row px-2">
        <label for="allergy" class="col-md-10 col-form-label text-md-left mt-1 font-weight-bold">Do you have any allergy?</label>
        <div class="col-md-2">
            <div class="custom-control custom-radio">
                <input type="radio" id="allergy_yes" name="allergy" class="custom-control-input" value="1" onclick="changeUpdate();" {{old('allergy') != null ? (old('allergy') == '1' ? 'checked' : '') : (isset($condition) ? ($condition->allergy == '1' ? 'checked' : '') : '')}}>
                <label class="custom-control-label" for="allergy_yes">YES</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="allergy_no" name="allergy" class="custom-control-input" value="0" onclick="changeUpdate();" {{old('allergy') != null ? (old('allergy') == '0' ? 'checked' : '') : (isset($condition) ? ($condition->allergy == '0' ? 'checked' : '') : '')}}>
                <label class="custom-control-label" for="allergy_no">NO</label>
            </div>
        </div>
    </div>
    @error('allergy')
        <div class="row px-3">
            <div class="alert alert-danger col-md-12">{{ $message }}</div>
        </div>
    @enderror
    <hr>
    <div class="form-group row px-2">
        <label for="special_diet" class="col-md-10 col-form-label text-md-left mt-1 font-weight-bold">Do you have any special dietary requirement (e.g. vegetarian food/halal food only)? </label>
        <div class="col-md-2">
            <div class="custom-control custom-radio">
                <input type="radio" id="special_diet_yes" name="special-diet" class="custom-control-input" value="1" onclick="changeUpdate();" {{old('special-diet') != null ? (old('special-diet') == '1' ? 'checked' : '') : (isset($condition) ? ($condition->special_diet == '1' ? 'checked' : '') : '')}}>
                <label class="custom-control-label" for="special_diet_yes">YES</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="special_diet_no" name="special-diet" class="custom-control-input" value="0" onclick="changeUpdate();" {{old('special-diet') != null ? (old('special-diet') == '0' ? 'checked' : '') : (isset($condition) ? ($condition->special_diet == '0' ? 'checked' : '') : '')}}>
                <label class="custom-control-label" for="special_diet_no">NO</label>
            </div>
        </div>
    </div>
    @error('special-diet')
        <div class="row px-3">
            <div class="alert alert-danger col-md-12">{{ $message }}</div>
        </div>
    @enderror
    <hr>
    <div class="form-group row px-2">
        <label for="convicted_crime" class="col-md-10 col-form-label text-md-left mt-1 font-weight-bold">Have you ever been convicted of a crime offense?</label>
        <div class="col-md-2">
            <div class="custom-control custom-radio">
                <input type="radio" id="convict_crime_yes" name="convicted-crime" class="custom-control-input" value="1" onclick="changeUpdate();" {{old('convicted-crime') != null ? (old('convicted-crime') == '1' ? 'checked' : '') : (isset($condition) ? ($condition->convicted_crime == '1' ? 'checked' : '') : '')}}>
                <label class="custom-control-label" for="convict_crime_yes">YES</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="convict_crime_no" name="convicted-crime" class="custom-control-input" value="0" onclick="changeUpdate();" {{old('convicted-crime') != null ? (old('convicted-crime') == '0' ? 'checked' : '') : (isset($condition) ? ($condition->convicted_crime == '0' ? 'checked' : '') : '')}}>
                <label class="custom-control-label" for="convict_crime_no">NO</label>
            </div>
        </div>
    </div>
    @error('convicted-crime')
        <div class="row px-3">
            <div class="alert alert-danger col-md-12">{{ $message }}</div>
        </div>
    @enderror
    <hr>
    <div class="form-group row px-2">
        <label for="test_type" class="col-md-10 col-form-label text-md-left mt-1 font-weight-bold">Do you foresee any other difficulty that may affect the completion of your study?</label>
        <div class="col-md-2">
            <div class="custom-control custom-radio">
                <input type="radio" id="diffs_yes" name="future-diffs" class="custom-control-input" value="1" onclick="changeUpdate();" {{old('future-diffs') != null ? (old('future-diffs') == '1' ? 'checked' : '') : (isset($condition) ? ($condition->future_diffs == '1' ? 'checked' : '') : '')}}>
                <label class="custom-control-label" for="diffs_yes">YES</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="diffs_no" name="future-diffs" class="custom-control-input" value="0" onclick="changeUpdate();" {{old('future-diffs') != null ? (old('future-diffs') == '0' ? 'checked' : '') : (isset($condition) ? ($condition->future_diffs == '0' ? 'checked' : '') : '')}}>
                <label class="custom-control-label" for="diffs_no">NO</label>
            </div>
        </div>
    </div>
    @error('future-diffs')
        <div class="row px-3">
            <div class="alert alert-danger col-md-12">{{ $message }}</div>
        </div>
    @enderror
    <hr>
    <div class="form-group row px-2">
        <label for="explanation" class="col-md-6 col-form-label text-md-left mt-1 font-weight-bold">Explanation</label>
        <div class="col-md-6 text-right">
            <textarea class="form-control @error('explanation') is-invalid @enderror" rows="5" style="resize: none;" name="explanation" onkeypress="changeUpdate();" autocomplete="off">{{old('explanation', isset($condition) ? $condition->reasons : '')}}</textarea>
        </div>
    </div>
    @error('explanation')
        <div class="row px-3">
            <div class="alert alert-danger col-md-12">{{ $message }}</div>
        </div>
    @enderror
    <hr>
    <div class="form-group row">
        <div class="col-md-12">
            <b>Note:</b><br>
            You no need to fill the explanation field if you answer any question with a 'YES'!
        </div>
    </div>

@endsection

@section('return-route')
{{route('student.csa-form.csa-page5')}}
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