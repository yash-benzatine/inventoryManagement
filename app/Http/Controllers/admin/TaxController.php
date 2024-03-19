<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Tax;
use DataTables;

class TaxController extends Controller
{
    public function index(Request $request)
    {
        return view("admin.tax.index");
    }



    public function store(Request $request)
    {
      try {
        // Validate the incoming request data
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'rate' => 'required|integer',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'errors' => $validatedData->errors(),
                'input' => $request->all(),
            ], 422);
        }
        // Create a new tax instance
        $tax = new Tax();
        $tax->name = $request->input('name');
        $tax->rate = $request->input('rate');
        $tax->save();
        $notification = array(
            'message' => 'Tax created successfully',
            'alert' => 'success'
        );

        // Redirect the user back or to a specific route after successful submission
        return response()->json($notification);
        } catch (ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
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
    public function edit($taxId)
    {
        $tax = Tax::find($taxId);
        return response()->json($tax);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|integer',
        ]);

        $tax = Tax::findOrFail($id);
        $tax->name = $request->input('name');
        $tax->rate = $request->input('rate');
        if($tax->save()) {
            $message = 'Tax created successfully.';
            return response()->json(['message' => $message, 'alert' => 'success']);
        }else{
            $message = 'Tax not created successfully.';
            return response()->json(['message' => $message, 'alert' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(tax $tax)
    {
        $tax->delete();
        return redirect()->back()->with(['message'=>'Tax deleted successfully', 'alert-type' => 'success']);
    }

    public function getData()
    {
        $data = Tax::orderBy('id', 'DESC');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="d-flex px-3 py-1 align-items-center"><a href="#" data-toggle="modal" data-target="#editTax" data-id="'. $row->id .'" class="edit-btn"><p class="text-sm font-weight-bold mb-0">Edit</p></a>
                <form action="'. route('tax.delete', ['tax' => $row]) .'" method="POST">
                                            '.csrf_field().'
                                            '.method_field('DELETE').'
                                        <a href="'. route('tax.delete', ['tax' => $row]) .'"><p class="text-sm font-weight-bold mb-0 ps-2">Delete</p></a>
                                        </form></div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
}
