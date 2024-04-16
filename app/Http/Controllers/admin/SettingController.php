<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SettingController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:setting-list', ['only' => ['index', 'store']]);
    }

    public function index(Request $request)
    {
        $setting = Auth::user();
        return view("admin.setting.index", compact('setting'));
    }

    public function store(Request $request)
    {
      try {
            // Validate the incoming request data
            $validatedData = Validator::make($request->all(), [
                'company_name' => 'string|max:255',
                'phone' => 'string|max:255',
                'email' => 'email|max:255',
                'address' => 'string|max:255',
                'currency' => 'string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ])->validate();

            // if ($validatedData->fails()) {
            //     return redirect()->back()->withErrors($validatedData)->withInput();
            // }

            $setting = Auth::user();
            $setting->company_name = $request->company_name;
            $setting->phone = $request->phone;
            $setting->email = $request->email;
            $setting->address = $request->address;
            $setting->currency = $request->currency;
            $setting->firstname = $request->firstname;
            $setting->lastname = $request->lastname;
            $setting->city = $request->city;
            $setting->country = $request->country;
            $setting->postal = $request->postal;
            $setting->about = $request->about;
            // Handle image upload if provided
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('admin/setting'), $imageName);
                $setting->image = $imageName;
            }
            $setting->update();

            // Redirect back with success message or do something else
            return redirect()->back()->with(['message'=> 'User updated successfully!', 'alert-type' => 'sucess']);
        } catch (ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with(['message'=> $e->getMessage(), 'alert-type' => 'warning']);
        }
    }
    
}
