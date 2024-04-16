<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use DataTables;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Sale;
use DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    

    function __construct()
    {
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','store']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view("admin.product.index");
    }

    public function create()
    {
        $categories = Category::where('cat_id', '=', 0)->get();
        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'status' => 'required|in:0,1',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // adjust image validation rules as needed
            'note' => 'nullable|string',
            'quantity' => 'required|numeric'
        ]);

        // Store the product with the generated serial number
        $product = new Product();
        $product->serial_number = $request->serial_number;
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->purchase_price = $request->purchase_price;
        $product->selling_price = $request->selling_price;
        $product->status = $request->status;
        $product->note = $request->note;
        $product->quantity = $request->quantity;
        $product->sub_category_id = $request->sub_category_id;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('admin/products'), $imageName);
            $product->image = $imageName;
        }

        $product->save();
        return redirect()->route('product.index')->with(['message'=> 'Product added successfully.', 'alert-type' => 'success']);
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
    public function edit(Product $product)
    {
        $categories = Category::where('cat_id', '=', 0)->get();
        $subcategories = Category::where('cat_id', $product->category_id)->get();
        return view('admin.product.edit', compact('product', 'categories', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'status' => 'required|in:0,1',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // adjust image validation rules as needed
            'note' => 'nullable|string',
            'quantity' => 'required|numeric'
        ]);
        $oldImage = $product->image;


        // Store the product with the generated serial number
        $product->serial_number = $request->serial_number;
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->purchase_price = $request->purchase_price;
        $product->selling_price = $request->selling_price;
        $product->status = $request->status;
        $product->note = $request->note;
        $product->quantity = $request->quantity;
        $product->sub_category_id = $request->sub_category_id;
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('admin/products'), $imageName);
            $product->image = $imageName;
        }

        if($product->save()){
            if ($oldImage) {
                Storage::delete('admin/products' . $oldImage);
            }
            return redirect()->route('product.index')->with(['message'=> 'Product updated successfully.', 'alert-type' => 'success']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($productId)
    {
        $product = Product::where('id', $productId)->first();
        $product->delete();
        return redirect()->back()->with(['message'=>'Product deleted successfully', 'alert-type' => 'success']);
    }

    public function getData()
    {
        $data = Product::select('*')->with(['category']);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                $status = ($row->status == 1) ? 'active' : 'inactive';
                $badgeColor = ($row->status == 1) ? 'success' : 'danger';

                return '<span class="badge badge-pill badge-sm badge-' . $badgeColor . '">' . $status . '</span>';
            })
            ->addColumn('category_id', function ($row) {
                return $row->category->name;
            })
            ->addColumn('inventory', function ($row) {
                if($row->quantity != NULL){
                    $inventory = $row->quantity;
                }else{

                    $totalQuantity = $row->quantity ?? 0;
                    // Get total quantity sold for the product
                    $totalSalesQuantity = DB::table('sales')->whereRaw("find_in_set($row->id,'product_id')")->sum('quantity');

                    // Calculate inventory (total quantity - total sales quantity)
                    $inventory = $totalQuantity - $totalSalesQuantity;
                }
                return $inventory;
            })
            ->addColumn('image', function ($row) {
                if($row->image != ''){
                    return '<a href="'. asset('admin/products/'. $row->image) .'" target="_blank"><img src="'. asset('admin/products/'. $row->image) .'" height="90" width="90" class="shadow-sm m-1"></a>';
                }else{
                    return '-';
                }
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="d-flex align-items-center"><a href="' . route('product.edit',['product' => $row->id]). '" class="btn btn-primary btn-icon-only mx-2" title="Edit Product"><span class="btn-inner--icon"><i class="fab fa fa-edit"></i></a>
                <form action="'. route('product.delete', $row->id) .'" method="POST">
                                            '.csrf_field().'
                                            '.method_field('DELETE').'
                                        <a href="'. route('product.delete', $row->id) .'" class="btn btn-danger btn-icon-only" title="Delete Product"><span class="btn-inner--icon"><i class="fab fa fa-trash"></i></a>
                                        </form></div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'status','image','category_id', 'inventory'])
            ->make(true);
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = Category::where('cat_id', $categoryId)->get();
        return response()->json(['data'=> $subcategories]);
    }
}
