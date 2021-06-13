<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Rules\MidLine;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware("permission:permissions-list", ["only" => ["index"]]);
        $this->middleware("permission:permissions-create", ["only" => ["create", "store"]]);
        $this->middleware("permission:permissions-edit", ["only" => ["edit", "update"]]);
        $this->middleware("permission:permissions-delete", ["only" => ["destroy"]]);
    }

    public function index()
    {
        $permissions = Permission::orderBy("id", "DESC")->get()->groupBy("group_name");
        return view("permissions.index", compact("permissions"));
    }

    public function create()
    {
        return view("permissions.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => ["required", "unique:permissions,name", new MidLine],
            "description" => "required"
        ]);
        
        $group_name = explode("-", $request->name)[0];
        $permission = Permission::create([
            "name" => $request->name,
            "description" => $request->description,
            "group_name" => $group_name,
        ]);

        return redirect()->route("permissions.index")->with("success", "Permission created successfully");
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view("permissions.edit", compact("permission"));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => ["required", "unique:permissions,name," . $id, new MidLine],
            "description" => "required"
        ]);
        
        $group_name = explode("-", $request->name)[0];

        $permission = Permission::findOrFail($id);
        $permission->name = $request->name;
        $permission->description = $request->description;
        $permission->group_name = $group_name;
        $permission->save();

        return redirect()->route("permissions.index")->with("success", "Permission updated successfully");
    }
}