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
    private function model_assignment($partner, $validatedData){
        $partner->major_id = $validatedData['major'];
        $partner->name = $validatedData['uni-name'];
        $partner->location = $validatedData['location'];
        $partner->short_detail = $validatedData['details'];
        $partner->min_gpa = $validatedData['min-gpa'];
        $partner->eng_requirement = $validatedData['eng-proficiency'];
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

    public function create(PartnerCRUD $request){
        $request->flash();
        $validatedData = $request->validated();
        $partner = new Partner;
        $this->model_assignment($partner, $validatedData);
        return redirect(route('staff.home'));
    }

    public function show_editPage(Partner $partner){
        return view('staff_side/master_partner/edit', ['referred_partner' => $partner, 'all_majors' => Major::all()]);
    }

    public function update(PartnerCRUD $request){
        $request->flash();
        $validatedData = $request->validated();
        $partner = Partner::find($validatedData['partner-id']);
        $this->model_assignment($partner, $validatedData);
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