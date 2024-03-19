<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Setting;


class SettingController extends Controller
{
    public function index(Request $request)
    {
        $setting = Setting::latest()->first();
        return view("admin.setting.index", compact('setting'));
    }

    public function create()
    {
        $categories = Category::where('cat_id', '=', 0)->get();
        return view('admin.category.create', compact('categories'));
    }

    public function store(Request $request)
    {
      try {
            // Validate the incoming request data
            $validatedData = Validator::make($request->all(), [
                'company_name' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'address' => 'required|string|max:255',
                'currency' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ])->validate();

            // if ($validatedData->fails()) {
            //     return redirect()->back()->withErrors($validatedData)->withInput();
            // }

            // Handle image upload if provided
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('admin/setting'), $imageName);
                $request->image = $imageName;
            }

            $setting = Setting::latest()->first();
            // Create a new company instance
            $setting->update([
                'company_name' => $request->company_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'currency' => $request->currency,
                'image' => $imageName ?? null, // Set image or null if not provided
            ]);

            // Redirect back with success message or do something else
            return redirect()->back()->with(['message'=> 'Company created successfully!', 'alert-type' => 'sucess']);
        } catch (ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with(['message'=> $e->getMessage(), 'alert-type' => 'warning']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::where('cat_id', '=', 0)->get();
        return view('admin.category.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string', // You might adjust this validation rule as needed
            'cat_id' => [
                'required_if:cat_id,0',
                'required',
                'integer',
            ],
        ]);

        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->status = $request->input('status');
        if($request->has('cat_id')){
            $category->cat_id = $request->input('cat_id');
            $route = 'sub-category.index';
            $message = 'Sub category created successfully.';
        }else{
            $route = 'category.index';
            $message = 'Category created successfully.';
        }
        if($category->save()) {
            return redirect()->route($route)->with(['message' => $message, 'alert-type' => 'success']);
        }else{
            return redirect()->back()->with(['message' => 'Data not updated successfully.', 'alert-type' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with(['message'=>'Category deleted successfully', 'alert-type' => 'success']);
    }

    public function getData()
    {
        $data = Category::where('cat_id', '=', 0)->orderBy('id', 'DESC');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                $status = ($row->status == 1) ? 'active' : 'inactive';
                $badgeColor = ($row->status == 1) ? 'success' : 'danger';

                return '<span class="badge badge-pill badge-sm badge-' . $badgeColor . '">' . $status . '</span>';
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="d-flex px-3 py-1 align-items-center"><a href="' . route('category.edit',['category' => $row->id]). '" class=""><p class="text-sm font-weight-bold mb-0">Edit</p></a>
                <form action="'. route('category.destroy', ['category' => $row]) .'" method="POST">
                                            '.csrf_field().'
                                            '.method_field('DELETE').'
                                        <a href="'. route('category.destroy', ['category' => $row]) .'"><p class="text-sm font-weight-bold mb-0 ps-2">Delete</p></a>
                                        </form></div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
}
