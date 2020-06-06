@extends('staff_side.crud_templates.create')

@section('entity')
    Yearly Partner
@endsection

@section('form-action')
    {{route('staff.yearly-partner.create-confirm')}}
@endsection

@section('form-inputs')
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text bg-info text-light" for="academic_year_selection">Academic Year</label>
        </div>
        <select class="custom-select @error('academic_year') is-invalid @enderror" id="academic_year_selection" name="academic_year">
            <option value=" ">Choose...</option>
            @foreach ($academic_years as $year)
                <option onclick="get_partners ({{$year->id}});" {{session('latest_yearly_partner_year_id') != null ? (session('latest_yearly_partner_year_id') == $year->id ? "selected" : "") : (old('academic_year') == $year-> id ? "selected" : "")}} value={{$year->id}}>
                    {{$year->starting_year}}/{{$year->ending_year}} - {{$year->odd_semester ? "Odd" : "Even"}}
                </option>
            @endforeach
        </select>
    </div>
    @error('academic_year')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text bg-info text-light" for="partner_selection">Partner Name</label>
        </div>
        <select class="custom-select @error('partner') is-invalid @enderror" id="partner_selection" name="partner">
            <option value=" ">
                @if($unpicked_partners->count() > 0)
                    Choose...
                @else
                    All partners have been added!!
                @endif
            </option>
            @foreach ($unpicked_partners as $partner)
                <option value="{{$partner->id}}">{{$partner->name}} | {{$partner->location}}</option>
            @endforeach
        </select>
    </div>
    @error('partner')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
@endsection

@section('confirm-value')
Yearly Partner
@endsection

@push('scripts')
    <script>
        function get_partners(academic_year_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var targetURL = '/staff/yearly-partner/academic-year/' + academic_year_id + '/partners';
            $.ajax({
                type: 'POST',
                url: targetURL,
                data: {_token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function(response_data){
                    if(response_data['failed'] == null){
                        var data = response_data['partners'];
                        $('#partner_selection').empty();
                        $('#partner_selection').append("<option value=\" \">" + (jQuery.isEmptyObject(data) == true ? "All partners have been added!!" : "Choose...") + "</option>");
                        $.each(data, function(i, val){
                            $('#partner_selection').append("<option value=\"" + data[i].id + "\">" + data[i].name + " | " + data[i].location + "</option>");
                        });
                    }
                }
            });
        }
    </script>
@endpush