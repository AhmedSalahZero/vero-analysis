<?php 
namespace App\Http\Controllers\Api ;

use Illuminate\Http\Request;

class UserController {
	public function register(Request $request)
	{
		dd($request->all());
	}
}
