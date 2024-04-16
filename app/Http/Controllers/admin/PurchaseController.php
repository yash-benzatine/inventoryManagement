<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use DataTables;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use App\Models\PurchaseHistory;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PurchaseController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:purchase-list|purchase-history|purchase-store|purchase-report', ['only' => ['index','store','reportIndex','report']]);
        $this->middleware('permission:purchase-store', ['only' => ['create','store']]);
        $this->middleware('permission:purchase-report', ['only' => ['reportIndex', 'report']]);
        $this->middleware('permission:purchase-history', ['only' => ['index2']]);  
    }

    public function index(Request $request)
    {
        $products = Product::where('status', 1)->get();
        $datas = Product::where(['status'=> 1, 'id'=>$request->productId])->orderBy('id', 'DESC');
        $suppliers = Supplier::where('status', 1)->get();
        return view("admin.purchase.index", compact('products', 'datas', 'suppliers'));
    }

    public function index2(Request $request)
    {
        return view("admin.purchase.purchase");
    }

    public function store(Request $request)
    {
      try {
        // Validate the incoming request data
        $validatedData = Validator::make($request->all(), [
            'purchase_code' => 'required|string|unique:purchases,purchase_code',
            'supplier_id' => 'required|string',
            'date' => 'required|date',
            'total' => 'required|numeric',
            'amount' => 'required|numeric',
            'due' => 'required|numeric',
            'paymentType' => 'required|string',
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $purchase = new Purchase();
        $purchase->purchase_code = $request->input('purchase_code');
        $purchase->supplier_id = $request->input('supplier_id');
        $purchase->date = $request->input('date');
        $purchase->total = $request->input('total');
        $purchase->amount = $request->input('amount');
        $purchase->due = $request->input('due');
        $purchase->payment_type = $request->input('paymentType');
        $purchase->save();
        if($purchase->save()){
            foreach ($request->input('data_id') as $key => $productId) {
                $purchaseHistory = new PurchaseHistory();
                $purchaseHistory->purchase_code = $purchase->purchase_code; // Set the product ID
                $purchaseHistory->product_id = $productId;
                $purchaseHistory->quantity = $request->input('purchase_quantity')[$key]; // Set the purchase quantity for this product
                $purchaseHistory->save();
            }
        }

        // Redirect back or return a response
        return redirect()->back()->with(['message'=> 'Purchase created successfully', 'alert-type' => 'success']);
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
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with(['message'=>'Category deleted successfully', 'alert-type' => 'success']);
    }

    public function getData(Request $request)
    {
        $data = Purchase::select('*')->with(['Supplier' => function($query) {
            $query->withTrashed(); // Filter out soft-deleted suppliers
        }])->get(); // Filter out soft-deleted purchases

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('supplier_id', function ($row) {
                return $row->Supplier->name;
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="d-flex align-items-center my-1"><a href="' . route('purchase.show', $row->purchase_code). '" class="btn btn-primary mx-2" title="View Purchase Detail"><span class="btn-inner--icon"><i class="fab fa fa-eye mx-1"></i>View</a>';
                
                if($row->due != 0){
                    $action = '<a href="'. route('purchase.due', $row->purchase_code) .'" class="btn btn-info" title="Purchase Due Detail"><span class="btn-inner--icon"><i class="fab fa fa-money mx-1"></i>Due</a></div>';
                }else{
                    $action = '<a href="#" class="btn btn-success" title="Purchase Paid"><span class="btn-inner--icon"><i class="fab fa fa-money mx-2"></i>Paid</a></div>';
                }
                return $actionBtn. $action;
            })
            ->rawColumns(['action', 'supplier_id'])
            ->make(true);
    }
    public function getData1(Request $request)
    {
        $data = Product::where(['id'=>$request->productId])->get();
        return response()->json(['product'=>$data, 'status'=>1]);
    }

    public function updateProducts(Request $request){
        $productId = $request->input('productId');
        if($request->quantity){
        //  return response()->json(['success' => true]);
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
        return view('admin.purchase.report');
    }

    public function report(Request $request){
        $data = Purchase::select('*')->with(['Supplier' => function($query){
            $query->withTrashed();
        }]);

        if ($request->filled('from') && $request->filled('to')) {
            $fromDate = Carbon::parse($request->from)->startOfDay(); // Parse and set time to start of day
            $toDate = Carbon::parse($request->to)->endOfDay(); // Parse and set time to end of day

            $data->whereDate('date', '>=', $fromDate)
                ->whereDate('date', '<=', $toDate);
        }

        // Fetch the data
        $result = $data->get();
            return Datatables::of($result)
            ->addIndexColumn()
            ->addColumn('supplier_id', function ($row) {
                return $row->Supplier->name;
            })
            ->rawColumns(['supplier_id'])
            ->make(true);
    }

    public function invoice($purchaseId){
        $purchases = PurchaseHistory::with(['Product' => function($query){
           $query->withTrashed(); // Include soft-deleted suppliers 
        }])->where('purchase_code', $purchaseId)->get();
        $purchase1 = Purchase::with(['Supplier' => function ($query) {
            $query->withTrashed(); // Include soft-deleted suppliers
        }])->withTrashed()->where('purchase_code', $purchaseId)->first();
        return view('admin.purchase.invoice', compact('purchases', 'purchase1'));
    }

    public function dueDetail($purchaseId){
        $purchase = Purchase::with(['PurchaseHistory','Supplier' => function($query){
            $query->withTrashed();
        }])->where('purchase_code', $purchaseId)->first();
        $purchase->load(['PurchaseHistory.Product' => function($query) {
            $query->withTrashed();
        }]);
        return view('admin.purchase.due', compact('purchase'));
    }

    public function update(Request $request, $purchaseId){
        try {
        // Validate the incoming request data
        $validatedData = Validator::make($request->all(), [
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'paymentType' => 'required|string',
        ]);

        // if ($validatedData->fails()) {
        //     return redirect()->back()->withErrors($validatedData)->withInput();
        // }

        $purchase = Purchase::where('purchase_code', $purchaseId)->first();
        $amount = $purchase->amount;
        $total = $amount + $request->input('amount');
        $subtotal = $purchase->total - $total;

        $purchase->date = $request->input('date');
        $purchase->amount =  $total;
        $purchase->due = $subtotal;
        $purchase->payment_type = $request->input('paymentType');
        $purchase->save();
            
        // Redirect back or return a response
        return redirect()->route('purchase.show', $purchase->purchase_code)->with(['message'=> 'Purchase updated successfully', 'alert-type' => 'success']);
        } catch (\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with(['message'=> $e->getMessage(), 'alert-type' => 'warning']);
        }
    }
}
