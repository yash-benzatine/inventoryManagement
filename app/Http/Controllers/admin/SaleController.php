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
use App\Models\SaleHistory;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SaleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:sales-history|sale-store|sale-report', ['only' => ['index','store']]);
        $this->middleware('permission:sale-store', ['only' => ['create','store']]);
        $this->middleware('permission:sale-report', ['only' => ['reportIndex', 'report']]);
        $this->middleware('permission:sales-history', ['only' => ['index2']]);  
    }

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
        $sale->customer = $request->input('customer_id');
        $sale->date = $request->input('date');
        $sale->sub_total = $request->input('sub_total');
        $sale->discount = $request->input('discount');
        $sale->vat = $request->input('vat');
        $sale->grand_total = $request->input('total');
        $sale->received_amount = $request->input('received_amount');
        $sale->due = $request->input('due');
        $sale->payment_type = $request->input('paymentType');
        if($sale->save()){
            foreach ($request->input('data_id') as $key => $productId) {
                $saleHistory = new SaleHistory();
                $saleHistory->invoice_code = $sale->invoice_code; // Set the product ID
                $saleHistory->product_id = $productId;
                $saleHistory->quantity = $request->input('sale_quantity')[$key]; // Set the purchase quantity for this product
                $saleHistory->save();
            }
        }


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
    public function update(Request $request, $saleId)
    {
        try {
        // Validate the incoming request data
        $validatedData = Validator::make($request->all(), [
            'date' => 'required|date',
            'received_amount' => 'required|numeric',
            'paymentType' => 'required|string',
        ]);

        // if ($validatedData->fails()) {
        //     return redirect()->back()->withErrors($validatedData)->withInput();
        // }

        $sale = Sale::where('invoice_code', $saleId)->first();
        $amount = $sale->received_amount;
        $total = $amount + $request->input('received_amount');
        $subtotal = $sale->grand_total - $total;

        $sale->date = $request->input('date');
        $sale->received_amount =  $total;
        $sale->due = $subtotal;
        $sale->payment_type = $request->input('paymentType');
        $sale->save();
            
        // Redirect back or return a response
        return redirect()->route('sale.show', $sale->invoice_code)->with(['message'=> 'sale updated successfully', 'alert-type' => 'success']);
        } catch (\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with(['message'=> $e->getMessage(), 'alert-type' => 'warning']);
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
        $data = Sale::select('*')->with(['Customer' => function($query){
            $query->withTrashed();
        }]);

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('customer', function ($row) {
                return $row->Customer->name;
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="d-flex px-3 py-1 align-items-center"><a href="' . route('sale.show', $row->invoice_code). '" class="btn btn-primary mx-2" title="Sale Detail View"><span class="btn-inner--icon"><i class="fab fa fa-eye mx-1"></i>View</a>';

                if($row->due != 0){
                    $action = '<a href="'. route('sale.due',  $row->invoice_code) .'" class="btn btn-info" title="Due Sale"><span class="btn-inner--icon"><i class="fab fa fa-money mx-1"></i>Due</a></div>';
                }else{
                    $action = '<a href="#" class="btn btn-success" title="Paid Sale"><span class="btn-inner--icon"><i class="fab fa fa-money mx-2"></i>Paid</a></div>';
                }
                return $actionBtn. $action;
            })
            ->rawColumns(['action', 'customer'])
            ->make(true);
    }
    public function getData1(Request $request)
    {
        // $data = Product::where(['id'=>$request->productId])->get();
        $data = Product::select('*')->with(['SubCategory'])
            ->when($request->filled('productId'), function ($query) use ($request) {
                return $query->where('id', $request->productId);
            })
            ->when($request->filled('subCategoryId'), function ($query) use ($request) {
                return $query->where('sub_category_id', $request->subCategoryId);
            })
            ->when($request->filled('categoryId'), function ($query) use ($request) {
                return $query->where('category_id', $request->categoryId);
            })
            ->get();
            if($request->productId != ""){
                $totalQuantitySold = SaleHistory::where('product_id', $request->productId)->sum('quantity');
            }else{
                $totalQuantitySold = "";
            }
        $subCategory = Category::where(['cat_id'=>$request->categoryId , 'status'=>1])->get();    
        return response()->json(['product'=>$data, 'status'=>1, 'subCategory'=> $subCategory, 'total_quantity' => $totalQuantitySold]);
    }

    public function updateProducts(Request $request){
        $productId = $request->input('productId');
        if($request->field == 'sale_quantity'){
            return response()->json(['success' => true]);
        }else{
            $field = $request->field;
            $value = $request->value;
            // Update the database table here
            $product = Product::findOrFail($productId);
            $product[$field] = $value;  
            $product->save();
            return response()->json(['success' => true]);
        }
    }

    public function reportIndex(){
        return view('admin.manage-sales.report');
    }

    public function report(Request $request){
        $data = Sale::select('*')->with(['Customer' => function($query){
            $query->withTrashed();
        }]);
         if ($request->filled('from') && $request->filled('to')) {
            $fromDate = Carbon::parse($request->from)->startOfDay(); // Parse and set time to start of day
            $toDate = Carbon::parse($request->to)->endOfDay(); // Parse and set time to end of day

            $data->whereDate('date', '>=', $fromDate)
                ->whereDate('date', '<=', $toDate);
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('customer', function ($row) {
                return $row->Customer->name;
            })
            ->rawColumns(['customer'])
            ->make(true);
    }

    public function invoice($saleId){
        $sale =  SaleHistory::with(['Product'=> function($query){
            $query->withTrashed();
        }])->where('invoice_code', $saleId)->get();
        $sale1 = Sale::with(['Customer' => function($query){
            $query->withTrashed();
        }])->where('invoice_code', $saleId)->first();
        return view('admin.manage-sales.invoice', compact('sale', 'sale1'));
    }

    public function dueDetail($saleId){
        $sale = Sale::with(['SaleHistory'])->where(['invoice_code'=> $saleId])->first();
        $sale->load(['SaleHistory.Product' => function($query) {
            $query->withTrashed();
        }]);
        return view('admin.manage-sales.due', compact('sale'));
    }

    public function quantity(request $request){
        if($request->productId != ""){
            $totalQuantitySold = SaleHistory::where('product_id', $request->productId)->sum('quantity');
        }else{
            $totalQuantitySold = "";
        }
        $quantity = $request->quantity - $totalQuantitySold;

        return response()->json(['total_quantity' => $quantity]);
    }
    
}
