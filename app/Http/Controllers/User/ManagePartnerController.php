<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerCRUD;
use App\Major;
use App\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagePartnerController extends Controller
{
    private function model_assignment($partner, $inputted_data){
        $partner->major_id = $inputted_data['major'];
        $partner->name = $inputted_data['uni-name'];
        $partner->location = $inputted_data['location'];
        $partner->short_detail = $inputted_data['details'];
        $partner->min_gpa = $inputted_data['min-gpa'];
        $partner->eng_requirement = $inputted_data['eng-proficiency'];
        $partner->save();
    }

    public function show_partnerPage(){
        return view('staff_side\master_partner\view', ['all_majors' => Major::all()]);
    }
    
    public function show_major_partners($id){
        $partners = Partner::where('major_id', $id)->get();
        return response()->json(['major_partners' => $partners->toArray()]);
    }

    public function show_partner_details(Partner $partner){
        // the referred partner id was implicitly bound to the model
        return view('staff_side\master_partner\detailed', ['referred_partner' => $partner]);
    }

    public function show_createPage(){
        return view('staff_side\master_partner\create', ['all_majors' => Major::all(), 'first_partner_id' => DB::table('partners')->orderBy('id')->first()->id]);
    }

    public function confirm_create(PartnerCRUD $request){
        $request->flash();
        $validatedData = $request->validated();
        $request->session()->put('inputted_partner', $validatedData);
        $validatedData['major'] = Major::find($validatedData['major'])->name;
        return view('staff_side/master_partner/create-confirm', ['inputted_partner' => $validatedData]);
    }

    public function create(){
        $inputted_partner = session('inputted_partner');
        $partner = new Partner;
        $this->model_assignment($partner, $inputted_partner);
        session()->forget('inputted_partner');
        return redirect(route('staff.home'));
    }

    public function show_editPage(Partner $partner){
        session()->put('referred_partner_id', $partner->id);
        return view('staff_side/master_partner/edit', ['referred_partner' => $partner, 'all_majors' => Major::all()]);
    }

    public function confirm_update(PartnerCRUD $request){
        $request->flash();
        $validatedData = $request->validated();
        $request->session()->put('inputted_partner', $validatedData);
        $validatedData['major'] = Major::find($validatedData['major'])->name;
        return view('staff_side/master_partner/update-confirm', ['referred_partner' => Partner::find(session('referred_partner_id')), 'inputted_partner' => $validatedData]);
    }

    public function update(){
        $inputted_partner= session('inputted_partner');
        $partner = Partner::find($inputted_partner['partner-id']);
        $this->model_assignment($partner, $inputted_partner);
        session()->forget(['inputted_partner', 'referred_partner_id']);
        return redirect(route('staff.home'));
    }

    public function delete(Request $request){
        $validatedData = $request->validate([
            'partner-id' => ['required', 'integer', 'exists:partners,id']
        ]);
        $partner = Partner::find($validatedData['partner-id']);
        $partner->delete();
        return redirect(route('staff.home'));
    }
}