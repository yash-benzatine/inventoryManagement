<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Category;
use App\Models\Customer;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\Tax;
use Carbon\Carbon;


class SaleController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where(['status'=> 1, 'cat_id'=>0])->get();
        $customers = Customer::where('status', 1)->get();
        $taxes = Tax::all();
        $invoice_code = $this->generateUniqueRandomNumber();

        return view("admin.manage-sales.index", compact('categories', 'customers', 'invoice_code', 'taxes'));
    }

    public function generateUniqueRandomNumber()
    {
        do {
            $randomNumber = mt_rand(100000000000, 999999999999); // Generate a 12-digit random number
        } while (Sale::where('invoice_code', $randomNumber)->exists()); // Check if the number exists in the sale table

        return $randomNumber;
    }

    public function index2(Request $request)
    {
        return view("admin.manage-sales.sale");
    }

    public function store(Request $request)
    {
      try {
        // Validate the incoming request data
        $validatedData = Validator::make($request->all(), [
            'invoice_code' => 'required|string|unique:sales,invoice_code',
            'customer_id' => 'required|string',
            'date' => 'required|date',
            'total' => 'required|numeric',
            'amount' => 'required|numeric',
            'due' => 'required|numeric',
            'paymentType' => 'required|string',
        ]);

        // if ($validatedData->fails()) {
        //     return redirect()->back()->withErrors($validatedData)->withInput();
        // }

        $sale = new Sale();
        $sale->invoice_code = $request->input('invoice_code');
        $sale->product_id = $request->input('data_id');
        $sale->customer = $request->input('customer_id');
        $sale->date = $request->input('date');
        $sale->sub_total = $request->input('sub_total');
        $sale->discount = $request->input('discount');
        $sale->vat = $request->input('vat');
        $sale->grand_total = $request->input('total');
        $sale->received_amount = $request->input('received_amount');
        $sale->due = $request->input('due');
        $sale->payment_type = $request->input('paymentType');

        // Save the sale
        $sale->save();

        // Redirect back or return a response
        return redirect()->back()->with(['message'=> 'sale created successfully', 'alert-type' => 'success']);
        } catch (\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->validator)->withInput();
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
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

    public function subCategory($categoryId)
    {
        $subCategories = Category::where(['status'=> 1, 'cat_id' => $categoryId])->get();
        $products = Product::where(['status'=> 1, 'category_id' => $categoryId])->get();
        return response()->json(['message'=>'Sub Category Data', 'alert-type' => 'success', 'data' => $subCategories, 'data_product' => $products]);
    }

    public function getData(Request $request)
    {
        $data = Sale::with('Customer')->orderBy('id', 'DESC')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('customer', function ($row) {
                return $row->Customer->name;
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
            ->rawColumns(['action', 'customer'])
            ->make(true);
    }
    public function getData1(Request $request)
    {
        // $data = Product::where(['id'=>$request->productId])->get();
        $data = Product::
            when($request->filled('productId'), function ($query) use ($request) {
                return $query->where('id', $request->productId);
            })
            ->when($request->filled('subCategoryId'), function ($query) use ($request) {
                return $query->where('sub_category_id', $request->subCategoryId);
            })
            ->orderBy('id', 'DESC')
            ->get();
        return response()->json(['product'=>$data, 'status'=>1]);
    }

    public function updateProducts(Request $request){
        $productId = $request->input('productId');
        $quantity = $request->input('quantity');
        $field = $request->field;
        $value = $request->value;
        // Update the database table here
        $product = Product::findOrFail($productId);
        $product[$field] = $value;
        $product->save();

        return response()->json(['success' => true]);
    }

    public function reportIndex(){
        return view('admin.manage-sales.report');
    }

    public function report(Request $request){
        $data = Sale::with('Customer');
         if ($request->filled('from') && $request->filled('to')) {
            $fromDate = Carbon::parse($request->from)->startOfDay(); // Parse and set time to start of day
            $toDate = Carbon::parse($request->to)->endOfDay(); // Parse and set time to end of day

            $data->whereDate('date', '>=', $fromDate)
                ->whereDate('date', '<=', $toDate);
        }

        $data->orderBy('id', 'DESC');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('customer', function ($row) {
                return $row->Customer->name;
            })
            ->rawColumns(['customer'])
            ->make(true);
    }
}
