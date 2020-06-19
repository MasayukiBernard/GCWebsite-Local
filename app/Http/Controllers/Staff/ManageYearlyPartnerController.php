<?php

namespace App\Http\Controllers\Staff;

use App\Academic_Year;
use App\Http\Controllers\Controller;
use App\Partner;
use App\Yearly_Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ManageYearlyPartnerController extends Controller
{
    private function unpicked_partners($id){
        $partner_ids = DB::table('yearly_partners')->select('partner_id')->where('academic_year_id', $id)->get();
        return DB::table('partners')->select('id', 'name', 'location')->whereNotIn('id', Arr::pluck($partner_ids, 'partner_id'))->get();
    }

    public function show_yearlyPartnerPage(){
        return view('staff_side/yearly_partner/view', ['academic_years' => Academic_Year::orderBy('ending_year', 'desc')->orderBy('odd_semester')->get()]);
    }

    public function show_yearlyPartnerDetails($academic_year_id){
        session()->put('latest_yearly_partner_year_id', $academic_year_id);
        return view('staff_side/yearly_partner/details', ['academic_year' => Academic_Year::find($academic_year_id), 'yearly_partners' => Yearly_Partner::where('academic_year_id', $academic_year_id)->get()]);
    }

    public function show_createPage(){
        return view('staff_side/yearly_partner/create', ['academic_years' => Academic_Year::orderBy('ending_year', 'desc')->orderBy('odd_semester')->get(), 'unpicked_partners' => $this->unpicked_partners(session('latest_yearly_partner_year_id'))]);
    }

    public function show_unpicked_partners($id){
        $academic_year = Academic_Year::where('id', $id)->first();
        if($academic_year != null){
            $partners = $this->unpicked_partners($id);
            return response()->json(['partners' => $partners]);
        }
        return response()->json(['failed' => true]);
    }

    public function confirm_create(Request $request){
        $validatedData = $request->validate([
            'academic_year' => ['required', 'integer', 'exists:academic_years,id'],
            'partner' => ['required', 'integer', 'exists:partners,id', Rule::notIn(Arr::pluck(DB::table('yearly_partners')->select('partner_id')->where('academic_year_id', $request['academic_year'])->get(), 'partner_id'))]
        ]);
        $request->session()->put('create_yearly_partner', ['academic_year' => $request['academic_year'],'partner' => $request['partner']]);
        return view('staff_side/yearly_partner/confirm-create', ['referred_partner' => Partner::find($request['partner']), 'referred_year' => Academic_Year::find($request['academic_year'])]);
    }

    public function create(){
        if(session('create_yearly_partner') != null){
            $yearly_partner = new Yearly_Partner;
            $yearly_partner->academic_year_id = session('create_yearly_partner')['academic_year'];
            $yearly_partner->partner_id = session('create_yearly_partner')['partner'];
            $yearly_partner->save();
            session()->forget(['latest_yearly_partner_year_id', 'create_yearly_partner']);
        }
        return redirect(route('staff.yearly-partner.create-page'));
    }

    public function confirm_delete($yearly_partner_id){
        $yearly_partner = Yearly_Partner::where('id', $yearly_partner_id)->first();
        if($yearly_partner != null){
            $academic_year = $yearly_partner->academic_year->starting_year . '/' . $yearly_partner->academic_year->ending_year . ' - ' . ($yearly_partner->academic_year->odd_semester ? 'Odd' : 'Even');
            session()->put('yearly_partner_id_to_delete', $yearly_partner_id);
            return response()->json([
                'yearly_partner_name' => $yearly_partner->partner->name,
                'academic_year' => $academic_year
            ]);
        }
        else{
            return response()->json(['failed' => true]);
        }
    }

    public function delete(){
        $yearly_partner = Yearly_Partner::where('id', session('yearly_partner_id_to_delete'))->first();
        session()->forget('yearly_partner_id_to_delete');
        if($yearly_partner != null){
            $yearly_partner->delete();
        }
        return redirect(route('staff.home'));
    }
}