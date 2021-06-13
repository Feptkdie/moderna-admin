<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;
use Hash;
use Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware("permission:users-list", ["only" => ["index"]]);
        $this->middleware("permission:users-create", ["only" => ["create", "store"]]);
        $this->middleware("permission:users-edit", ["only" => ["edit", "update"]]);
        $this->middleware("permission:users-delete", ["only" => ["destroy"]]);
    }

    public function index(Request $request)
    {
        $search_lastname = $request->lastname;
        $search_firstname = $request->firstname;
        $search_email = $request->email;

        $users = User::where("lastname", "LIKE", "%". $search_lastname . "%")
            ->where("firstname", "LIKE", "%". $search_firstname . "%")
            ->where("email", "LIKE", "%". $search_email . "%")
            ->orderBy("created_at", "DESC")
            ->paginate(20);

        $users->appends($request->all());
        return view("users.index", compact("users"));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $permissions = Permission::orderBy("id", "DESC")->get()->groupBy("group_name");
        return view("users.edit", compact("user", "roles", "permissions"));
    }

    public function update(Request $request, $id)
    {
        $roles = [];
        
        if (!empty($request->role)) {
            array_push($roles, $request->role);    
        }

        $request->validate([
            "lastname" => "required|string|min:2|max:255",
            "firstname" => "required|string|min:2|max:255",
            "email" => "required|string|email|max:255|unique:users,email," . $id,
            "password" => "nullable|string|min:6|confirmed"
        ]);

        $user = User::findOrFail($id);
        $user->lastname = $request->lastname;
        $user->firstname = $request->firstname;
        $user->email = $request->email;
        
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        $user->syncRoles($roles);
        $user->syncPermissions($request->permissions);

        return redirect()->route("users.index")->with("success", "User updated successfully");
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $user = User::findOrFail($id);
            deleteImageForSingle($user->avatar);
            $user->delete();

            Session::flash("success", "User deleted successfully");
            return response()->json(["success" => true]);
        }
    }
}
