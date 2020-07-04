<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerCRUD;
use App\Major;
use App\Partner;
use Illuminate\Support\Arr;
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
        $success = $failed = null;
        if(session('success_notif') != null){
            $success = session('success_notif');
        }
        else if (session('failed_notif') != null){
            $failed = session('failed_notif');
        }
        session()->forget(['success_notif', 'failed_notif']);

        return view('staff_side\master_partner\view', [
            'all_majors' => Major::orderBy('name')->get(),
            'success' => $success,
            'failed' => $failed
        ]);
    }
    
    public function show_major_partners($id, $field, $sort_type){
        session()->put('last_picked_major_id', $id);
        
        $available_fields = array('name', 'location', 'short_detail', 'min_gpa', 'eng_requirement');
        $sort_types = array('a' => 'asc', 'd' => 'desc');
        
        if(is_numeric($id) && in_array($field, $available_fields) && Arr::exists($sort_types, $sort_type)){
            $partners = Partner::where('major_id', $id)->orderBy($field, $sort_types[$sort_type])->get();
            return response()->json([
                'major_partners' => $partners,
                'failed' => false
            ]);
        }
        
        return response()->json([
            'failed' => true
        ]);
    }

    public function show_partner_details(Partner $partner){
        session()->put('referred_partner_id', $partner->id);
        return view('staff_side\master_partner\detailed', ['referred_partner' => $partner]);
    }

    public function show_createPage(){
        $first_major = DB::table('majors')->select('id')->get()->first();
        if($first_major == null){
            session()->put('failed_notif', 'Cannot make a new partner yet, please create at least 1 record of major!');
            return redirect(route('staff.partner.page'));
        }
        
        return view('staff_side\master_partner\create', ['all_majors' => Major::orderBy('name')->get()]);
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

        session()->put('success_notif', 'You have successfuly CREATED 1 new partner record!');
        return redirect(route('staff.partner.page'));
    }

    public function show_editPage(Partner $partner){
        return view('staff_side/master_partner/edit', ['referred_partner' => $partner, 'all_majors' => Major::orderBy('name')->get()]);
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
            session()->put('success_notif', 'You have successfuly UPDATED 1 new partner record!');
        }
        else{
            session()->put('failed_notif', 'System failed to update partner record!');   
        }

        return redirect(route('staff.partner.page'));
    }

    public function delete(){
        $partner = Partner::where('id', session('referred_partner_id'))->first();
        if($partner != null){
            $partner->delete();
            session()->forget('referred_partner_id');
            session()->put('success_notif', 'You have successfuly DELETED 1 new partner record!');
        }
        else{
            session()->put('failed_notif', 'System failed to delete partner record!');   
        }

        return redirect(route('staff.partner.page'));
    }
}