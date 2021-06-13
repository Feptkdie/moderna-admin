<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserCar;
use App\Models\UserCarPart;

use Validator;
use Hash;
use Auth;
use Storage;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "lastname" => ["required", "string", "max:255"],
            "firstname" => ["required", "string", "max:255"],
            "email" => ["required", "string", "email", "max:255", "unique:users"],
            "password" => ["required", "string", "min:6", "max:50"],
            "phone" => ["nullable", "string", "min:8", "max:100"],
        ]);

        if ($validator->fails()) {
            return response()->json(["error" => "Unauthorized", "message" => $validator->errors()], 401);
        } else {
            $user = new User;
            $user->lastname = $request->lastname;
            $user->firstname = $request->firstname;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->avatar = "";
            $user->save();

            return $this->login($request);
        } 
    }
    
    public function login()
    {
        $credentials = request(["email", "password"]);

        if (! $token = Auth::guard("api")->attempt($credentials)) {
            return response()->json(["error" => "Unauthorized"], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        $user = Auth::guard("api")->user();        
        return response()->json($user);
    }

    public function logout()
    {
        Auth::guard("api")->logout();
        return response()->json(["message" => "Successfully logged out"]);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::guard("api")->refresh());
    }

    protected function respondWithToken($token)
    {
        $user = Auth::guard("api")->user()->load("cars", "cars.parts");
            
        return response()->json([
            "user" => $user,
            "access_token" => $token,
            "token_type" => "bearer",
            "expires_in" => Auth::guard("api")->factory()->getTTL() * 60
        ]);
    }

    public function changePassword(Request $request)
    {
        $input = $request->all();
        $userId = Auth::guard("api")->user()->id;
        
        $rules = array(
            "old_password" => "required",
            "new_password" => "required|min:6",
            "confirm_password" => "required|same:new_password",
        );

        $validator = Validator::make($input, $rules);
        
        if ($validator->fails()) {
            $arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
        } else {
            try {
                if ((Hash::check(request("old_password"), Auth::user()->password)) == false) {
                    $arr = array("status" => 400, "message" => "The old password is wrong");
                } else if ((Hash::check(request("new_password"), Auth::user()->password)) == true) {
                    $arr = array("status" => 400, "message" => "The new password is the same as the old password");
                } else {
                    User::where("id", $userId)->update(["password" => Hash::make($input["new_password"])]);
                    $arr = array("status" => 200, "message" => "Your password has been successfully changed. You can log in now");
                }
            } catch (\Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                $arr = array("status" => 400, "message" => $msg);
            }
        }
        return response()->json($arr);
    }

    public function updateUser(Request $request)
    {
        $userId = Auth::guard("api")->user()->id;

        $user = User::findOrFail($userId);

        if ($request->has("avatar") && $request->avatar && $request->avatar_name) {
            deleteImageForSingle($user->avatar);

            $file_content = base64_decode($request->avatar);
            $mime_type = explode(".", $request->avatar_name)[1];
            $image_path = "users/".\Str::random(40).'.'.$mime_type;

            // Upload s3 disk
            Storage::disk('s3')->put($image_path, $file_content, "public");
            $user->avatar = Storage::disk('s3')->url($image_path);
        } 


        $user->lastname = $request->lastname;
        $user->firstname = $request->firstname;
        $user->phone = $request->phone;
        // $user->email = $request->email;
        $user->save();

        return response()->json(["success" => true, "user" => $user]);
    }

    public function addCar(Request $request)
    {
        $request->validate([
            "name" => "required",
            "mark_name" => "required",
            "country_number" => "required",
        ]);

        $userId = Auth::guard("api")->user()->id;

        $userCar = new UserCar;
        $userCar->name = $request->name;
        $userCar->group_name = $request->group_name;
        $userCar->mark_name = $request->mark_name;
        $userCar->country_number = $request->country_number;
        $userCar->vin_number = $request->vin_number;
        $userCar->color = $request->color;
        $userCar->made_in_year = $request->made_in_year;
        $userCar->import_year = $request->import_year;
        $userCar->user_id = $userId;
        $userCar->save();

        $auth = Auth::guard("api")->user()->load("cars", "cars.parts");
        $cars  = $auth["cars"];
        return response()->json(["success" => true, "data" => $cars]);
    }

    public function editCar(Request $request, $id)
    {
        $request->validate([
            "name" => "required",
            "mark_name" => "required",
            "country_number" => "required",
        ]);

        $userCar = UserCar::findOrFail($id);

        if ($request->has("cover") && $request->cover && $request->cover_name) {
            deleteImageForSingle($userCar->cover);

            $file_content = base64_decode($request->cover);
            $mime_type = explode(".", $request->cover_name)[1];
            $image_path = "users/cars/".\Str::random(40).'.'.$mime_type;

            // Upload s3 disk
            Storage::disk('s3')->put($image_path, $file_content, "public");
            $userCar->cover = Storage::disk('s3')->url($image_path);
        }

        if ($request->has("image") && $request->image && $request->image_name) {
            deleteImageForSingle($userCar->image);

            $file_content = base64_decode($request->image);
            $mime_type = explode(".", $request->image_name)[1];
            $image_path = "users/cars/".\Str::random(40).'.'.$mime_type;

            // Upload s3 disk
            Storage::disk('s3')->put($image_path, $file_content, "public");
            $userCar->image = Storage::disk('s3')->url($image_path);
        }

        $userCar->name = $request->name;
        $userCar->group_name = $request->group_name;
        $userCar->mark_name = $request->mark_name;
        $userCar->country_number = $request->country_number;
        $userCar->vin_number = $request->vin_number;
        $userCar->color = $request->color;
        $userCar->made_in_year = $request->made_in_year;
        $userCar->import_year = $request->import_year;
        $userCar->save();

        $auth = Auth::guard("api")->user()->load("cars", "cars.parts");
        $cars  = $auth["cars"];
        return response()->json(["success" => true, "data" => $cars]);
    }

    public function deleteCar($id)
    {
        $userCar = UserCar::findOrFail($id);
        deleteImageForSingle($userCar->cover);
        deleteImageForSingle($userCar->image);
        $userCar->delete();

        $auth = Auth::guard("api")->user()->load("cars", "cars.parts");
        $cars  = $auth["cars"];
        return response()->json(["success" => true, "data" => $cars]);
    }

    public function addPart(Request $request)
    {
        $request->validate([
            "name" => "required",
            "user_car_id" => "required"
        ]);

        $part = new UserCarPart;
        $part->name = $request->name;
        $part->type = $request->type;
        $part->purchased_at = $request->purchased_at;
        $part->replaced_at = $request->replaced_at;
        $part->replaced_item = $request->replaced_item;
        $part->address = $request->address;
        $part->description = $request->description;
        $part->user_car_id = $request->user_car_id;
        $part->save();

        $auth = Auth::guard("api")->user()->load("cars", "cars.parts");
        $cars  = $auth["cars"];
        return response()->json(["success" => true, "data" => $cars]);
    }

    public function editPart(Request $request, $id)
    {
        $request->validate([
            "name" => "required"
        ]);

        $part = UserCarPart::findOrFail($id);
        $part->name = $request->name;
        $part->type = $request->type;
        $part->purchased_at = $request->purchased_at;
        $part->replaced_at = $request->replaced_at;
        $part->replaced_item = $request->replaced_item;
        $part->address = $request->address;
        $part->description = $request->description;
        $part->save();

        $auth = Auth::guard("api")->user()->load("cars", "cars.parts");
        $cars  = $auth["cars"];
        return response()->json(["success" => true, "data" => $cars]);
    }

    public function deletePart($id)
    {
        $userCarPart = UserCarPart::findOrFail($id);
        $userCarPart->delete();

        $auth = Auth::guard("api")->user()->load("cars", "cars.parts");
        $cars  = $auth["cars"];
        return response()->json(["success" => true, "data" => $cars]);
    }
}
