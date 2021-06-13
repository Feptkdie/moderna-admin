<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view("roles.index", compact("roles"));
    }

    public function create()
    {
        $permissions = Permission::orderBy("id", "DESC")->get()->groupBy("group_name");
        return view("roles.create", compact("permissions"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:roles,name"
        ]);
        
        $role = Role::create(["name" => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route("roles.index")->with("success", "Role created successfully");
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::orderBy("id", "DESC")->get()->groupBy("group_name");
        return view("roles.edit", compact("role", "permissions"));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|unique:roles,name," . $id
        ]);
        
        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();

        $role->syncPermissions($request->permissions);

        return redirect()->route("roles.index")->with("success", "Role updated successfully");
    }
}
