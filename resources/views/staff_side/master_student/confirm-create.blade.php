@extends('staff_side.crud_templates.confirm')

@section('entity-crud')
    Batch of Student
@endsection

@section('entity-distinct-content')
    <table class="table table-bordered">
        <thead class="thead-dark">
            <th colspan="4">
                All of the following batch of students will be added with default data as such below
            </th>
        </thead>
        <tbody>
            <tr>
                <th scope="row">Name</th><td>-</td>
                <th scope="row">Major</th><td>{{$first_major->name}}</td>
            </tr>
            <tr>
                <th scope="row">Gender</th><td>-</td>
                <th scope="row">Place of Birth</th><td>-</td>
            </tr>
            <tr>
                <th scope="row">Email</th><td>Randomized</td>
                <th scope="row">Date of Birth</th><td>1st January 1970</td>
            </tr>
            <tr>
                <th scope="row">Mobile Number</th><td>-</td>
                <th scope="row">Nationality</th><td>-</td>
            </tr>
            <tr>
                <th scope="row">Telephone Number</th><td>-</td>
                <th scope="row">Address</th><td>-</td>
            </tr>
        </tbody>
    </table>
    
    <hr>
    
    <?php $i = 0;?>
    @foreach ($enrolling_students['nims'] as $nim)
        @if ($nim != null && $enrolling_students['passwords'][$i] != null)
            <table class="table table-bordered">
                <thead class="h4">
                    <th colspan="2">Student #{{($i+1)}}</th>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">NIM</th>
                        <td>{{$nim}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Password</th>
                        <td>{{Str::limit($enrolling_students['passwords'][$i], 5, '...')}}</td>
                    </tr>
                </tbody>
            </table>
        @endif
        <?php ++$i?>
    @endforeach
@endsection

@section('form-action')
{{route('staff.student.create')}}
@endsection

@section('return-route')
{{route('staff.student.create-page')}}
@endsection