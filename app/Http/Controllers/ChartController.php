<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartController extends Controller
{

    public function index(){
        $data =  $initial_percentages = $this->count_percentages($academic_years->first()->id, "HTML5");
        $chart = Charts::database($data, 'bar', 'highcharts')
			      ->title("Submitted Form")
			      ->elementLabel("Total Student")
			      ->dimensions(1000, 500)
			      ->responsive(false);

		$pie  =	 Charts::create('pie', 'highcharts')
				    ->title('Submitted Form')
				    ->labels(['Submitted', 'Nominated'])
				    ->values([5,10,20])
				    ->dimensions(1000,500)
                    ->responsive(false);
        
                    return view('user', compact('chart', 'pie'));
    }
}
