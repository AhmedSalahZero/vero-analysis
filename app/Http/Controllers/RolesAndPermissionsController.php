<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsController extends Controller
{
    public function index($scope)
    {
        $roles = Role::where('scope',$scope)->get();
        return view('super_admin_view.roles_and_permissions.index',compact('scope','roles'));
    }
    public function create($scope)
    {
        $sections = Section::where('section_side','client')->get();
        return view('super_admin_view.roles_and_permissions.form',compact('scope','sections'));
    }
    public function store(Request $request ,$scope)
    {
        $role = Role::create(['name' => $request->role,'scope' => $scope]);
        $role->syncPermissions(array_keys($request->permissions));
        toastr()->success(__('Created Successfully'));
        return redirect()->back();

    }
    public function edit($scope,Role $role)
    {
        $role->load('permissions');

        $sections = Section::where('section_side','client')->get();
        return view('super_admin_view.roles_and_permissions.form',compact('role','scope','sections'));
    }
    public function update(Request $request ,$scope,Role $role)
    {
        $role->update(['name' => $request->role,'scope' => $scope]);
        $role->syncPermissions(array_keys($request->permissions));
        toastr()->success(__('updated Successfully'));
        return redirect()->back();
    }
}
