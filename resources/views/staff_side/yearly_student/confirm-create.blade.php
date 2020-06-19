@extends('staff_side.crud_templates.confirm')

@section('entity-crud')
    New Yearly Student
@endsection

@section('entity-distinct-content')
    <div class="row justify-content-center h4">
        {{$referred_year->starting_year}}/{{$referred_year->ending_year}} - {{$referred_year->odd_semester ? "Odd" : "Even"}}
    </div>
    <?php $i = 0?>
    @foreach ($students as $student)
        <table class="table table-bordered table-sm">
            <thead class="thead-dark">
                <th># No</th>
                <th>{{++$i}}</th>
            </thead>
            <tbody>
                <tr>
                    <th>Binusian Year</th>
                    <th>{{$student->binusian_year}}</th>
                </tr>
                <tr>
                    <th scope="row">NIM</th>
                    <td>{{$student->nim}}</td>
                </tr>
                <tr>
                    <th scope="row">Name</th>
                    <td>{{$student->user->name}}</td>
                </tr>
                <tr>
                    <th scope="row">Gender</th>
                    <td>{{$student->user->gender === 'M' ? 'Male' : 'Female'}}</td>
                </tr>
                <tr>
                    <th scope="row">Major</th>
                    <td>0{{$student->major->gpa}}</td>
                </tr>
                <tr>
                    <th scope="row">Nationality</th>
                    <td>{{$student->nationality}}</td>
                </tr>
            </tbody>
        </table>
    @endforeach
@endsection

@section('form-action')
{{route('staff.yearly-student.create')}}
@endsection

@section('return-route')
{{route('staff.yearly-student.create-page')}}
@endsection