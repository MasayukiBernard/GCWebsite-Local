<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
Use Illuminate\Support\Str;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param string $path
     * @return \Illuminate\Http\Response
     */
    public function show($path)
    {
        /*
            url format = /photos/{table}_id={id}&opt={column}
        */
        $table  = Str::before($path, '_');
        $id     = Str::between($path, 'id=', '&');
        $column = Str::after($path, 'opt=');
        $actual_path = null;
        if($table === 'users'){
            $table = 'students';
            if(DB::table($table)->where('user_id', $id)->first() != null){
                $actual_path = DB::table($table)->select($column)->where('user_id', $id)->first()->$column;
            }
        }
        else{
            $actual_path = DB::table($table)->select($column)->where('id', $id)->first()->$column;
        }

        if($actual_path != null){
            if(Storage::disk('private')->exists($actual_path)){
                return response()->file(storage_path('app\private\\' . $actual_path));
            }
        }
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
