<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use DataTables;
use App\Models\Product;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('status', 1)->get();
        $datas = Product::where(['status'=> 1, 'id'=>$request->productId])->orderBy('id', 'DESC');
        return view("admin.purchase.index", compact('products', 'datas'));
    }

    public function create()
    {
        $products = Product::where('status', 1)->get();
        return view('admin.purchase.create', compact('products'));
    }

    public function store(Request $request)
    {
      try {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string', // You might adjust this validation rule as needed
            'cat_id' => [
                'required_if:cat_id,0',
                'required',
                'integer',
            ]
            ],[
                'cat_id' => 'Please select category.',
        ]);


        // Create a new category instance
        $category = new Category();
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->status = $request->input('status');
        if($request->input('cat_id')){
            $category->cat_id = $request->input('cat_id');
            $route = 'sub-category.index';
            $message = 'Sub category created successfully.';
        }else{
            $route = 'category.index';
            $message = 'Category created successfully.';
        }

        // Save the category to the database
        $category->save();
        $notification = array(
            'message' => $message,
            'alert-type' => 'success'
        );

        // Redirect the user back or to a specific route after successful submission
        return redirect()->route($route)->with($notification);
        } catch (ValidationException $e) {
    // Handle validation errors
    return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with('error', $e->getMessage());
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

    public function getData(Request $request)
    {
        $data = Product::where(['status'=>1, 'id'=>$request->productId])->orderBy('id', 'DESC');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                $status = ($row->status == 1) ? 'active' : 'inactive';
                $badgeColor = ($row->status == 1) ? 'success' : 'danger';

                return '<span class="badge badge-pill badge-sm badge-' . $badgeColor . '">' . $status . '</span>';
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="d-flex px-3 py-1 align-items-center"><a href="' . route('product.edit',['product' => $row->id]). '" class=""><p class="text-sm font-weight-bold mb-0">Edit</p></a>
                <form action="'. route('product.destroy', ['product' => $row]) .'" method="POST">
                                            '.csrf_field().'
                                            '.method_field('DELETE').'
                                        <a href="'. route('product.destroy', ['product' => $row]) .'"><p class="text-sm font-weight-bold mb-0 ps-2">Delete</p></a>
                                        </form></div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
    public function getData1(Request $request)
    {
        $data = Product::where(['id'=>$request->productId])->get();
        return response()->json(['product'=>$data, 'status'=>1]);
    }
}
