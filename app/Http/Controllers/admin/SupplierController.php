<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use DataTables;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        return view("admin.supplier.index");
    }

    public function create()
    {
        return view('admin.supplier.create');
    }

    public function store(Request $request)
    {
        try {
            // Validate the form data
            $validator = Validator::make($request->all(), [
                'company_name' => 'required|string',
                'name' => 'required|string',
                'email' => 'nullable|email',
                'phone' => 'required|string',
                'status' => 'required|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming max file size is 2MB
            ]);

            if ($validator->fails()) {
                return response()->json([
                        'errors' => $validator->errors(),
                        'input' => $request->all(),
                    ], 422);

            }

            // Handle file upload if an image is provided
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('admin/supplier');
                $validatedData['image'] = $imagePath;
            }

            // Create a new Supplier instance with the validated data
            Supplier::create($request->all());

            $notification = [
                'message' => "Supplier created successfully.",
                'alert' => 'success'
            ];

            // Redirect back or to a specific route
            return response()->Json($notification);
        }catch (ValidationException $e) {
            // Handle validation errors
            return response()->Json()->withErrors($e->errors())->withInput();
        }  catch (\Exception $e) {
            $notification = [
                'message' => $e->getMessage(),
                'alert' => 'error'
            ];

            return response()->Json($notification);
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
    public function edit($supplierId)
    {
        $supplier = Supplier::find($supplierId);
        return response()->json($supplier);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        try {
            // Validate the form data
            $validator = Validator::make($request->all(), [
                'company_name' => 'required|string',
                'name' => 'required|string',
                'email' => 'nullable|email',
                'phone' => 'required|string',
                'status' => 'required|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming max file size is 2MB
            ]);

            if ($validator->fails()) {
                return response()->json([
                        'errors' => $validator->errors(),
                        'input' => $request->all(),
                    ], 422);
            }

            // Handle file upload if an image is provided
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('admin/supplier');
                $validatedData['image'] = $imagePath;
            }

            // Create a new Supplier instance with the validated data
            $supplier->update($request->all());

            $notification = [
                'message' => "Supplier updated successfully.",
                'alert' => 'success'
            ];

            // Redirect back or to a specific route
            return response()->Json($notification);
        }catch (ValidationException $e) {
            // Handle validation errors
            return response()->Json()->withErrors($e->errors())->withInput();
        }  catch (\Exception $e) {
            $notification = [
                'message' => $e->getMessage(),
                'alert' => 'error'
            ];

            return response()->Json($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->back()->with(['message'=>'supplier deleted successfully', 'alert-type' => 'success']);
    }

    public function getData()
    {
        $data = Supplier::orderBy('id', 'DESC');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                $status = ($row->status == 1) ? 'active' : 'inactive';
                $badgeColor = ($row->status == 1) ? 'success' : 'danger';

                return '<span class="badge badge-pill badge-sm badge-' . $badgeColor . '">' . $status . '</span>';
            })
            ->addColumn('image', function ($row) {
                if($row->image != ''){
                    return '<img src="'. asset('admin/supplier/'. $row->image) .'" height="50" width="50" class="border-radius-lg shadow-sm">';
                }else{
                    return '-';
                }
            })
            ->addColumn('gender', function ($row) {
                $gender = ($row->gender == 'm') ? 'Male' : 'Female';
                $badgeColor = ($row->gender == 'm') ? 'default' : 'primary';

                return '<span class="badge badge-pill badge-'. $badgeColor .'">' . $gender . '</span>';
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="d-flex px-3 py-1 align-items-center"><a class="edit-btn" data-toggle="modal" data-target="#editSupplier" data-id="'. $row->id .'"><p class="text-sm font-weight-bold mb-0">Edit</p></a>
                <form action="'. route('supplier.delete', ['supplier' => $row]) .'" method="POST">
                                            '.csrf_field().'
                                            '.method_field('DELETE').'
                                        <a href="'. route('supplier.delete', ['supplier' => $row]) .'"><p class="text-sm font-weight-bold mb-0 ps-2">Delete</p></a>
                                        </form></div>';
                return $actionBtn;
            })
            ->rawColumns(['action','status', 'gender','image'])
            ->make(true);
    }
}
