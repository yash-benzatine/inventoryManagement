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
        return view("sub-category.index");
    }

    public function create()
    {
        $categories = Category::where('cat_id', '=', 0)->get();
        return view('sub-category.create', compact('categories'));
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
        return view('sub-category.edit', compact('category', 'categories'));
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
        $data = Category::with(['category'])->where('cat_id', '!=', 0)->orderBy('id', 'DESC');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('cat_id', function ($row) {
                $name = isset($row->category->name) ? $row->category->name : '---';
                return $name;
            })
            ->addColumn('status', function ($row) {
                $status = ($row->status == 1) ? 'active' : 'inactive';
                $badgeColor = ($row->status == 1) ? 'success' : 'danger';

                return '<div class="align-middle text-center text-sm"><span class="badge badge-sm bg-gradient-' . $badgeColor . '">' . $status . '</span></div>';
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="d-flex px-3 py-1 justify-content-center align-items-center"><a href="' . route('sub-category.edit', $row->id). '" class=""><p class="text-sm font-weight-bold mb-0">Edit</p></a>
                <form action="'. route('sub-category.destroy', ['category' => $row]) .'" method="POST">
                                            '.csrf_field().'
                                            '.method_field('DELETE').'
                                        <a href="'. route('sub-category.destroy', ['category' => $row]) .'"><p class="text-sm font-weight-bold mb-0 ps-2">Delete</p></a>
                                        </form></div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'status','cat_id'])
            ->make(true);
    }
}
