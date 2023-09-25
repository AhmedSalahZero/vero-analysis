<?php
namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Log;
use App\Models\Section;

class AnalysisReports
{
    public function salesAnalysisReports(Company $company)
    {
        // $route_name = preg_replace('/(?<!\ )[A-Z]/', ' $0', request()->segment(4));
        if (request()->segment(4) == 'SalesBreakdownAnalysis') {
			Log::storeNewLogRecord('enterSection',null,__('Sales Breakdown Analysis'));
			
            $id = 60;
        }elseif (request()->segment(4) == 'SalesTrendAnalysis') {
			Log::storeNewLogRecord('enterSection',null,__('Sales Trend Analysis'));
            $id = 62;
        }
        $section = Section::with('subSections')->find($id);

        $exportableFields  = (new ExportTable)->customizedTableField($company, 'SalesGathering', 'selected_fields');
        $viewing_names = array_values($exportableFields);

        return view('client_view.analysis_reports_lists',compact('company','viewing_names','section'));
    }
}
