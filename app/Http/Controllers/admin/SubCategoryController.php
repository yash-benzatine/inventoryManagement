<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use DataTables;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        return view("admin.sub-category.index");
    }

    public function create()
    {
        $categories = Category::where('cat_id', '=', 0)->get();
        return view('admin.sub-category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string', // You might adjust this validation rule as needed
            'cat_id' => 'required|integer',
        ]);


        // Create a new category instance
        $category = new Category();
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->status = $request->input('status');
        $category->cat_id = $request->input('cat_id');
        // Save the category to the database
        $category->save();
        $notification = array(
            'message' => 'Sub category created successfully.',
            'alert-type' => 'success'
        );

        // Redirect the user back or to a specific route after successful submission
        return redirect()->route('sub-category.index')->with($notification);
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
    public function edit($categoryId)
    {
        $categories = Category::where('cat_id', '=', 0)->get();
        $category = Category::where('id', $categoryId)->first();
        return view('admin.sub-category.edit', compact('category', 'categories'));
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
            'cat_id' => 'required|integer',
        ]);

        dd($status);
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->status = $request->input('status');
        $category->cat_id = $request->input('cat_id');
        if($category->save()) {
            return redirect()->route('sub-category.index')->with(['message' => 'Sub category updated successfully.', 'alert-type' => 'success']);
        }else{
            return redirect()->back()->with(['message' => 'Sub category not updated successfully.', 'alert-type' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('sub-category.index')->with(['message'=>'Sub Category deleted successfully', 'alert-type' => 'success']);
    }

    public function getData()
    {
        $data = Category::select('*')->with(['category'])->where('cat_id', '!=', 0);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('cat_id', function ($row) {
                $name = isset($row->category->name) ? $row->category->name : '---';
                return $name;
            })
            ->addColumn('status', function ($row) {
                $status = ($row->status == 1) ? 'active' : 'inactive';
                $badgeColor = ($row->status == 1) ? 'success' : 'danger';

                return '<span class="badge badge-pill badge-sm badge-' . $badgeColor . '">' . $status . '</span>';
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="d-flex align-items-center my-1"><a href="' . route('sub-category.edit', $row->id). '" class="btn btn-primary btn-icon-only mx-2"><span class="btn-inner--icon" title="Edit Sub Category"><i class="fab fa fa-edit"></i></a>
                <form action="'. route('sub-category.destroy', ['category' => $row]) .'" method="POST">
                                            '.csrf_field().'
                                            '.method_field('DELETE').'
                                        <a href="'. route('sub-category.destroy', ['category' => $row]) .'" class="btn btn-danger btn-icon-only" title="Delete Sub Category"><span class="btn-inner--icon"><i class="fab fa fa-trash"></i></a>
                                        </form></div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'status','cat_id'])
            ->make(true);
    }
}
