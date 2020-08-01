@extends('student_side.crud_templates.update')

@section('entity')
    Profile
@endsection

@section('old-data')
    <table class="table table-bordered">
        <tr>
            <th scope="row" class="align-middle">Profile Picture</th>
            <td class="text-center">
                <img src="/photos/mt={{$filemtimes['pp']}}&ys=0&opt=profile-picture" width="150vw" alt="No Data Yet" class="img-thumbnail border-secondary">
            </td>
        </tr>
        <tr>
            <th scope="row" class="align-middle">ID Card Picture</th>
            <td class="text-center">
                <img src="/photos/mt={{$filemtimes['ic']}}&ys=0&opt=id-card" width="150vw" alt="No Data Yet" class="img-thumbnail border-secondary">
            </td>
        </tr>
        <tr>
            <th scope="row" class="align-middle">Flazz Card Picture</th>
            <td class="text-center">
                <img src="/photos/mt={{$filemtimes['fc']}}&ys=0&opt=flazz-card" width="150vw" alt="No Data Yet" class="img-thumbnail border-secondary">
            </td>
        </tr>
        <tr>
            <th scope="row">Name</th>
            <td>{{$old_user->name}}</td>
        </tr>
        <tr>
            <th scope="row">Email</th>
            <td>{{$old_user->email}}</td>
        </tr>
        <tr>
            <th scope="row">NIM</th>
            <td>{{$old_user->student->nim}}</td>
        </tr>
        <tr>
            <th scope="row">Gender</th>
            <td>{{$old_user->gender === '-' ? '-' : ($old_user->gender === 'M' ? 'Male' : 'Female')}}</td>
        </tr>
        <tr>
            <th scope="row">Mobile Phone Number</th>
            <td>0{{$old_user->mobile}}</td>
        </tr>
        <tr>
            <th scope="row">Telephone Number</th>
            <td>0{{$old_user->telp_num}}</td>
        </tr>
        <tr>
            <th scope="row">Enrolled Major</th>
            <td>{{$old_user->student->major->name}}</td>
        </tr>
        <tr>
            <th scope="row">Place of Birth</th>
            <td>{{$old_user->student->place_birth}}</td>
        </tr>
        <tr>
            <th scope="row">Date of Birth</th>
            <td>{{$old_user->student->date_birth}}</td>
        </tr>
        <tr>
            <th scope="row">Nationality</th>
            <td>{{$old_user->student->nationality}}</td>
        </tr>
        <tr>
            <th scope="row">Address</th>
            <td>{{$old_user->student->address}}</td>
        </tr>
    </table>    
@endsection

@section('form-action')
{{route('student.profile-edit-confirm')}}
@endsection

@section('form-inputs')
<table class="table table-bordered">
        <tr>
            <th scope="row" class="align-middle">Profile Picture</th>
            <td>
                <div id="pp_file_dialog">
                    Do you want to edit the file? <button type="button" class="btn btn-success ml-1 px-4" onclick="show_element('pp_file', 'pp_file_dialog');">Yes</button>
                </div>
                <div id="pp_file" class="custom-file d-none">
                    <input type="file" name="profile-picture" id="profile-picture" onchange="changeLabel('profile-picture-label', 'profile-picture');" class="custom-file-input @error('profile-picture') is-invalid @enderror"  style="cursor: pointer;">
                    <label class="custom-file-label" id="profile-picture-label" for="profile-picture">Choose profile picture file</label>
                    <small id="file_size" class="form-text text-muted m-0">Maximum uploaded file size is 2 Megabytes.</small>
                </div>
                @error('profile-picture')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <th scope="row" class="align-middle">ID Card Picture</th>
            <td>
                <div id="ic_file_dialog">
                    Do you want to edit the file? <button type="button" class="btn btn-success ml-1 px-4" onclick="show_element('ic_file', 'ic_file_dialog');">Yes</button>
                </div>
                <div id="ic_file" class="custom-file d-none">
                    <input type="file" name="id-card" id="id-card" onchange="changeLabel('id-card-label', 'id-card');" class="custom-file-input @error('id-card') is-invalid @enderror" style="cursor: pointer;">
                    <label class="custom-file-label" id="id-card-label" for="id-card">Choose ID card picture file</label>
                    <small id="file_size" class="form-text text-muted m-0">Maximum uploaded file size is 2 Megabytes.</small>
                </div>
                @error('id-card')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <th scope="row" class="align-middle">Flazz Card Picture</th>
            <td>
                <div id="fc_file_dialog">
                    Do you want to edit the file? <button type="button" class="btn btn-success ml-1 px-4" onclick="show_element('fc_file', 'fc_file_dialog');">Yes</button>
                </div>
                <div id="fc_file" class="custom-file d-none">
                    <input type="file" name="flazz-card" id="flazz-card" onchange="changeLabel('flazz-card-label', 'flazz-card');" class="custom-file-input @error('flazz-card') is-invalid @enderror"  style="cursor: pointer;">
                    <label class="custom-file-label" id="flazz-card-label" for="flaz-card">Choose Flazz Card picture file</label>
                    <small id="file_size" class="form-text text-muted m-0">Maximum uploaded file size is 2 Megabytes.</small>
                </div>
                @error('flazz-card')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <th scope="row" class="align-middle">Name</th>
            <td> 
                <input type="text" autocomplete="off" name="name" maxlength="75" placeholder="Format: [First] [Middles (opt)] [Last]" class="form-control @error('name') is-invalid @enderror" value="{{old('name', $old_user->name)}}">
                @error('name')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <th scope="row" class="align-middle">Email</th>
            <td>
                <input type="email" autocomplete="off" name="email" maxlength="50" class="form-control @error('email') is-invalid @enderror" value="{{old('email', $old_user->email)}}">
                @error('email')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <th scope="row" class="align-middle">NIM</th>
            <td>
                <input type="text" autocomplete="off" name="nim" disabled class="form-control" value="{{$old_user->student->nim}}">
            </td>
        </tr>
        <tr>
            <th scope="row" class="align-middle">Gender</th>
            <td>
                <div class="custom-control custom-radio d-inline-block mr-3">
                    <input type="radio" id="male" name="gender" class="custom-control-input @error('gender') is-invalid @enderror" value="M" {{old('gender') == null ? ($old_user->gender === 'M' ? "Checked" : "") : (old('gender') == 'M' ? "Checked" : "")}}>
                    <label class="custom-control-label" for="male">Male</label>
                </div>
                <div class="custom-control custom-radio d-inline-block">
                    <input type="radio" id="female" name="gender" class="custom-control-input @error('gender') is-invalid @enderror" value="F" {{old('gender') == null ? ($old_user->gender === 'F' ? "Checked" : "") : (old('gender') == 'F' ? "Checked" : "")}}>
                    <label class="custom-control-label" for="female">Female</label><br>
                </div>
                @error('gender')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <th scope="row" class="align-middle">Mobile Phone Number</th>
            <td>
                <div class="row">
                    <div class="col-1 p-0 text-right pt-2">0</div>
                    <div class="col-11">
                        <input type="text" autocomplete="off" name="mobile" maxlength="13" class="form-control @error('mobile') is-invalid @enderror" value="{{old('mobile', $old_user->mobile)}}">
                    </div>
                </div>
                @error('mobile')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <th scope="row" class="align-middle">Telephone Number</th>
            <td>
                <div class="row">
                    <div class="col-1 p-0 text-right pt-2">0</div>
                    <div class="col-11">
                        <input type="text" autocomplete="off" name="telp-num" maxlength="14" class="form-control @error('telp-num') is-invalid @enderror" value="{{old('telp-num', $old_user->telp_num)}}">
                    </div>
                </div>
                @error('telp-num')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <th scope="row" class="align-middle">Enrolled Major</th>
            <td>
                <select class="custom-select" name="major">
                    <option value=" ">Pick a Major</option>
                    @foreach ($all_major as $major)
                        <option value="{{$major->id}}" {{old('major') == null ? ($old_user->student->major->id == $major->id ? "selected" : "") : (old('major') == $major->id ? "selected" : "")}}>
                            {{$major->name}}
                        </option>
                    @endforeach
                </select>
                @error('major')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <th scope="row" class="align-middle">Place of Birth</th>
            <td>
                <input type="text" autocomplete="off" name="place-birth" maxlength="50" class="form-control @error('place-birth') is-invalid @enderror" value="{{old('place-birth', $old_user->student->place_birth)}}">
                @error('place-birth')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror    
            </td>
        </tr>
        <tr>
            <th scope="row" class="align-middle">Date of Birth</th>
            <td>
                <input type="text" autocomplete="off" name="date-birth" maxlength="10" placeholder="Format: YYYY-MM-DD" class="form-control @error('date-birth') is-invalid @enderror" value="{{old('date-birth', $old_user->student->date_birth)}}">
                @error('date-birth')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror    
            </td>
        </tr>
        <tr>
            <th scope="row" class="align-middle">Nationality</th>
            <td>
                <input type="text" autocomplete="off" name="nationality" maxlength="20" class="form-control @error('nationality') is-invalid @enderror" value="{{old('nationality', $old_user->student->nationality)}}">
                @error('nationality')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror    
            </td>
        </tr>
        <tr>
            <th scope="row" class="align-middle">Address</th>
            <td>
                <textarea name="address" maxlength="200" class="form-control @error('address') is-invalid @enderror" rows="3">{{old('address', $old_user->student->address)}}</textarea>
                @error('address')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror    
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center">
                <input type="submit" class="btn btn-primary" value="Confirm New Profile Data">
            </td>
        </tr>
    </table>
@endsection

@push('scripts')
<script>
    function changeLabel(label_id, input_id){
        document.getElementById(label_id).innerHTML = document.getElementById(input_id).files[0].name;
    }

    function show_element($id, $causer_id){
        $('#' + $id).removeClass('d-none');
        $('#' + $causer_id).addClass('d-none');
    }
</script>
@endpush