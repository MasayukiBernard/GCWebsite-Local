<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerCRUD;
use App\Major;
use App\Partner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        session()->put('last_picked_major_id', $id);
        $partners = Partner::where('major_id', $id)->get();
        return response()->json(['major_partners' => $partners->toArray()]);
    }

    public function show_partner_details(Partner $partner){
        session()->put('referred_partner_id', $partner->id);
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
        session()->forget(['last_picked_major_id', 'inputted_partner']);
        return redirect(route('staff.home'));
    }

    public function show_editPage(Partner $partner){
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
        $inputted_partner = session('inputted_partner');
        $partner = Partner::where('id', session('referred_partner_id'))->first();
        if($partner != null){
            $this->model_assignment($partner, $inputted_partner);
            session()->forget(['inputted_partner', 'referred_partner_id']);
        }
        return redirect(route('staff.partner.page'));
    }

    public function delete(){
        $partner = Partner::where('id', session('referred_partner_id'))->first();
        if($partner != null){
            $partner->delete();
            session()->forget('referred_partner_id');
        }
        return redirect(route('staff.partner.page'));
    }
}