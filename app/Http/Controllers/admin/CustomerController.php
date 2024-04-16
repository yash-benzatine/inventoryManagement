<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CustomerController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:customer-list|customer-create|customer-edit|customer-delete', ['only' => ['index','store']]);
         $this->middleware('permission:customer-create', ['only' => ['create','store']]);
         $this->middleware('permission:customer-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view("admin.customer.index");
    }

    public function create()
    {
        return view('admin.customer.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => ['required', 'regex:/^\+?\d{8,}$/'], // Assuming a minimum of 8 digits
            'address' => 'required|string',
            'discount' => 'nullable|numeric',
            'status' => 'required|in:0,1',
            'gender' => 'required|in:m,f',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming image upload
        ]);

        // Create a new customer instance
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->discount = $request->discount;
        $customer->status = $request->status;
        $customer->gender = $request->gender;

        // Handle file upload if present
        if ($request->file('image')) {
            $image = $request->file('image');
            // dd($image);
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('admin/customer'), $imageName);
            $customer->image = $imageName;
        }

        // Save the customer record
        $customer->save();

        // Redirect back with success message
        return redirect()->route('customer.index')->with(['message'=> 'Customer created successfully', 'alert-type' => 'success']);
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
    public function edit(Customer $customer)
    {
        return view('admin.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => ['required', 'regex:/^\+?\d{8,}$/'], // Assuming a minimum of 8 digits
            'address' => 'required|string',
            'discount' => 'nullable|numeric',
            'status' => 'required|in:0,1',
            'gender' => 'required|in:m,f',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming image upload
        ]);

        // Create a new customer instance
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->discount = $request->discount;
        $customer->status = $request->status;
        $customer->gender = $request->gender;

        // Handle file upload if present
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('admin/customer'), $imageName);
            $customer->image = $imageName;
        }

        // Save the customer record
        $customer->save();

        // Redirect back with success message
        return redirect()->route('customer.index')->with(['message'=>'Customer updated successfully', 'alert-type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->back()->with(['message'=>'Customer deleted successfully', 'alert-type' => 'success']);
    }

    public function getData()
    {
        $data = Customer::select('*');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                $status = ($row->status == 1) ? 'active' : 'inactive';
                $badgeColor = ($row->status == 1) ? 'success' : 'danger';

                return '<span class="badge badge-pill badge-sm badge-' . $badgeColor . '">' . $status . '</span>';
            })
            ->addColumn('image', function ($row) {
                if($row->image != ''){
                    return '<a href="'. asset('admin/customer/'. $row->image) .'" target="_blank"><img src="'. asset('admin/customer/'. $row->image) .'" height="50" width="50" class="border-radius-lg shadow-sm m-1"></a>';
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
                $actionBtn = '<div class="d-flex px-3 py-1 align-items-center justify-content-center"><a href="' . route('customer.edit',['customer' => $row->id]). '" class="btn btn-primary btn-icon-only mx-2" title="Edit Customer"><span class="btn-inner--icon"><i class="fab fa fa-edit"></i></a>
                <form action="'. route('customer.destroy', ['customer' => $row]) .'" method="POST">
                                            '.csrf_field().'
                                            '.method_field('DELETE').'
                                        <a href="'. route('customer.delete', ['customer' => $row]) .'" class="btn btn-danger btn-icon-only" title="Delete Supplier"><span class="btn-inner--icon"><i class="fab fa fa-trash"></i></a>
                                        </form></div>';
                return $actionBtn;
            })
            ->rawColumns(['action','status', 'gender','image'])
            ->make(true);
    }
}
