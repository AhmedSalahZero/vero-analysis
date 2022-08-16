<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Providers\RouteServiceProvider;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function redirectTo()
    {
        return route('home');
    }
    protected function authenticated(Request $request, $user)
    {
        // Via the global helper...
        // $company =  Auth::user()->companies()->where('type','single')->first();

        // $company = $company ?? Auth::user()->companies()->where('type','group')->first()->subCompanies()->first();
        // session(['company_id' => $company->id]);

        // return redirect()->intended('home');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
