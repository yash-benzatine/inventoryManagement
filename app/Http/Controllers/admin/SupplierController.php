<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class SupplierController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:supplier-list|supplier-create|supplier-edit|supplier-delete', ['only' => ['index','store']]);
         $this->middleware('permission:supplier-create', ['only' => ['create','store']]);
         $this->middleware('permission:supplier-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:supplier-delete', ['only' => ['destroy']]);
    }

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

        
            $supplier = new Supplier();
            $supplier->company_name = $request->company_name;
            $supplier->phone = $request->phone;
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->status = $request->status;
            // Handle file upload if an image is provided
            if ($request->file('image')) {
                $image = $request->file('image');
                // dd($image);
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('admin/supplier'), $imageName);
                $supplier->image = $imageName;
            }
            $supplier->save();

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
                $image = $request->file('image');
                // dd($image);
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('admin/supplier'), $imageName);
                $supplier->image = $imageName;
            }

            $supplier->company_name = $request->company_name;
            $supplier->phone = $request->phone;
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->status = $request->status;

            $supplier->update();

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
        $data = Supplier::select('*');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                $status = ($row->status == 1) ? 'active' : 'inactive';
                $badgeColor = ($row->status == 1) ? 'success' : 'danger';

                return '<span class="badge badge-pill badge-sm badge-' . $badgeColor . '">' . $status . '</span>';
            })
            ->addColumn('image', function ($row) {
                if($row->image != ''){
                    return '<a href="'. asset('admin/supplier/'. $row->image) .'" target="_blank"><img src="'. asset('admin/supplier/'. $row->image) .'" height="50" width="50" class="border-radius-lg shadow-sm m-1"></a>';
                }else{
                    return '-';
                }
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="d-flex px-3 py-1 justify-content-center"><a href="#" data-toggle="modal" data-target="#editSupplier" data-id="'. $row->id .'" class="btn btn-primary btn-icon-only edit-btn mx-2" title="Edit Supplier">
                <span class="btn-inner--icon"><i class="fab fa fa-edit"></i></span>
              </a>
                <form action="'. route('supplier.delete', ['supplier' => $row]) .'" method="POST">
                                            '.csrf_field().'
                                            '.method_field('DELETE').'
                                        <a href="'. route('supplier.delete', ['supplier' => $row]) .'" class="btn btn-danger btn-icon-only" title="Delete Supplier"><span class="btn-inner--icon"><i class="fab fa fa-trash"></i></a>
                                        </form></div>';
                return $actionBtn;
            })  
            ->rawColumns(['action','status', 'image'])
            ->make(true);
    }
}
