<?php

namespace App\Http\Controllers\Staff;

use App\Academic_Year;
use App\Http\Controllers\Controller;
use App\Major;
use App\Partner;
use App\Yearly_Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ManageYearlyPartnerController extends Controller
{
    private function unpicked_partners($id){
        $partner_ids = DB::table('yearly_partners')
                            ->select('partner_id')
                            ->where('latest_deleted_at', null)->where('academic_year_id', $id)
                            ->get();
        return DB::table('partners')
                    ->join('majors', 'partners.major_id', '=', 'majors.id')
                    ->select('partners.id as id', 'partners.name as name', 'partners.location', 'majors.name as major_name')
                    ->where('partners.latest_deleted_at', null)->where('majors.latest_deleted_at', null)
                    ->whereNotIn('partners.id', Arr::pluck($partner_ids, 'partner_id'))
                    ->get();
    }

    public function show_yearlyPartnerPage(){
        $success = $failed = null;
        if(session('success_notif') != null){
            $success = session('success_notif');
        }
        else if (session('failed_notif') != null){
            $failed = session('failed_notif');
        }
        session()->forget(['success_notif', 'failed_notif']);
        
        return view('staff_side/yearly_partner/view', [
            'academic_years' => Academic_Year::orderBy('ending_year', 'desc')->orderBy('odd_semester')->get(),
            'success' => $success,
            'failed' => $failed
        ]);
    }

    public function show_yearlyPartnerDetailsPage($academic_year_id){
        session()->forget('latest_yearly_partner_year_id');
        session()->put('latest_yearly_partner_year_id', $academic_year_id);

        $success = $failed = null;
        if(session('success_notif') != null){
            $success = session('success_notif');
        }
        else if (session('failed_notif') != null){
            $failed = session('failed_notif');
        }
        session()->forget(['success_notif', 'failed_notif']);
        
        return view('staff_side/yearly_partner/details', [
            'academic_year' => Academic_Year::where('id', $academic_year_id)->first(),
            'all_majors' => Major::orderBy('name')->get(),
            'success' => $success,
            'failed' => $failed
        ]);
    }

    public function get_yearlyPartnerDetails($academic_year_id, $major_id, $field, $sort_type){
        $available_fields = array('name', 'location');
        $sort_types = array('a' => 'asc', 'd' => 'desc');

        if(is_numeric($academic_year_id) && in_array($field, $available_fields) && Arr::exists($sort_types, $sort_type)){
            $yearly_partners = DB::table('yearly_partners')
                                    ->select('partner_id')
                                    ->where('latest_deleted_at', null)->where('academic_year_id', $academic_year_id)
                                    ->get();
            $partners = Partner::whereIn('id', Arr::pluck($yearly_partners, 'partner_id'))->where('major_id', $major_id)->orderBy($field, $sort_types[$sort_type])->get();

            if($partners->first() != null){
                return response()->json([
                    'yearly-partners' => $partners,
                    'failed' => false
                ]);
            }
        }

        return response()->json([
            'failed' => true
        ]);
    }

    public function show_createPage(){
        return view('staff_side/yearly_partner/create', [
            'academic_years' => Academic_Year::orderBy('ending_year', 'desc')->orderBy('odd_semester')->get(), 
            'unpicked_partners' => $this->unpicked_partners(session('latest_yearly_partner_year_id'))
        ]);
    }

    public function show_unpicked_partners($id){
        $academic_year = Academic_Year::where('id', $id)->first();
        if($academic_year != null){
            $partners = $this->unpicked_partners($id);
            return response()->json([
                'partners' => $partners,
                'failed' => false
            ]);
        }
        return response()->json(['failed' => true]);
    }

    public function confirm_create(Request $request){
        $validatedData = $request->validate([
            'academic_year' => ['required', 'integer', 'exists:academic_years,id'],
            'partner' => ['required', 'integer', 'exists:partners,id', Rule::notIn(Arr::pluck(
                DB::table('yearly_partners')
                    ->select('partner_id')
                    ->where('latest_deleted_at', null)->where('academic_year_id', $request['academic_year'])
                    ->get(), 'partner_id'
            ))]
        ]);
        $request->session()->put('create_yearly_partner', ['academic_year' => $request['academic_year'], 'partner' => $request['partner']]);
        return view('staff_side/yearly_partner/confirm-create', ['referred_partner' => Partner::find($request['partner']), 'referred_year' => Academic_Year::find($request['academic_year'])]);
    }

    public function create(){
        $create_data = session('create_yearly_partner');
        $academic_year = Academic_Year::where('id', $create_data['academic_year'])->first();
        $partner = Partner::where('id', $create_data['partner'])->first();

        if($create_data != null){
            if($academic_year == null || $partner == null){
                $notif_message = '';
                if($academic_year == null){
                    $notif_message = "academic year";
                }
                else if($partner == null){
                    $notif_message = "partner";
                }
                session()->put('failed_notif', 'Failed to add a new yearly partner record! Missing referred '. $notif_message . '!');
                if($partner == null){
                    return redirect(route('staff.yearly-partner.details', ['academic_year_id' => session('latest_yearly_partner_year_id')]));
                }
                else if($academic_year == null){
                    return redirect(route('staff.yearly-partner.page'));
                }
            }

            $existing_yearly_partner = DB::table('yearly_partners')
                                        ->select('id')
                                        ->where('partner_id', $create_data['partner'])->where('academic_year_id', $create_data['academic_year'])
                                        ->first();

            if($existing_yearly_partner != null){
                Yearly_Partner::onlyTrashed()->where('id', $existing_yearly_partner->id)->restore();
            }
            else{
                $yearly_partner = new Yearly_Partner;
                $yearly_partner->academic_year_id = session('create_yearly_partner')['academic_year'];
                $yearly_partner->partner_id = session('create_yearly_partner')['partner'];
                $yearly_partner->latest_updated_at = null;
                $yearly_partner->save();
            }
            session()->forget('create_yearly_partner');
            session()->put('success_notif', 'You have successfuly CREATED 1 new yearly partner record!');
        }

        return redirect(route('staff.yearly-partner.details', ['academic_year_id' => session('latest_yearly_partner_year_id')]));
    }

    public function confirm_delete($academic_year_id, $partner_id){
        $yearly_partner = null;
        
        if(is_numeric($academic_year_id) && is_numeric($partner_id)){
            $yearly_partner = Yearly_Partner::where('academic_year_id', $academic_year_id)->where('partner_id', $partner_id)->first();
        }

        if($yearly_partner != null){
            $academic_year = $yearly_partner->academic_year->starting_year . '/' . $yearly_partner->academic_year->ending_year . ' - ' . ($yearly_partner->academic_year->odd_semester ? 'Odd' : 'Even');
            session()->put('yearly_partner_id_to_delete', $yearly_partner->id);

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
            session()->put('success_notif', 'You have successfuly DELETED 1 new partner record!');
        }
        else{
            session()->put('failed_notif', 'System failed to delete yearly partner record!');
        }

        return redirect(route('staff.yearly-partner.details', ['academic_year_id' => session('latest_yearly_partner_year_id')]));
    }
}