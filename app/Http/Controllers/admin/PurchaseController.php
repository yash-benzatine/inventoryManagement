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


class PurchaseController extends Controller
{
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
        $purchase->product_id = $request->input('data_id');
        $purchase->supplier_id = $request->input('supplier_id');
        $purchase->date = $request->input('date');
        $purchase->total = $request->input('total');
        $purchase->amount = $request->input('amount');
        $purchase->due = $request->input('due');
        $purchase->payment_type = $request->input('paymentType');

        // Save the purchase
        $purchase->save();

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
        $data = Purchase::with(['Supplier'])->orderBy('id', 'DESC');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('supplier_id', function ($row) {
                return $row->Supplier->name;
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
        return view('admin.purchase.report');
    }

    public function report(Request $request){
        $data = Purchase::with(['Supplier']);

        if ($request->filled('from') && $request->filled('to')) {
            $fromDate = Carbon::parse($request->from)->startOfDay(); // Parse and set time to start of day
            $toDate = Carbon::parse($request->to)->endOfDay(); // Parse and set time to end of day

            $data->whereDate('date', '>=', $fromDate)
                ->whereDate('date', '<=', $toDate);
        }

        $data->orderBy('id', 'DESC');

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
}
