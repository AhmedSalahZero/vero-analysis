<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\ToolTipData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class LogController extends Controller
{
   public function show()
  {
	if(!Auth()->user()->isSuperAdmin())
	{
		abort(404);
	}
	return view('super_admin_view.logs.index',[
		'logs'=>Log::all()
	]);
  }
}
