<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        return view("category.index");
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string', // You might adjust this validation rule as needed
        ]);

        // Create a new category instance
        $category = new Category();
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->status = $request->input('status');

        // Save the category to the database
        $category->save();
        $notification = array(
            'message' => 'Category created successfully.',
            'alert-type' => 'success'
        );

        // Redirect the user back or to a specific route after successful submission
        return redirect()->route('category.index')->with($notification);
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
        return view('category.edit', compact('category'));
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
        ]);

        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->status = $request->input('status');
        if($category->save()) {
            return redirect()->route('category.index')->with(['message' => 'Category updated successfully.', 'alert-type' => 'success']);
        }else{
            return redirect()->back()->with(['message' => 'Category not updated successfully.', 'alert-type' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with(['message'=>'Category deleted successfully', 'alert-type' => 'success']);
    }

    public function getData()
    {
        $data = Category::select('*');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                $status = ($row->status == 1) ? 'active' : 'inactive';
                $badgeColor = ($row->status == 1) ? 'success' : 'danger';

                return '<div class="align-middle text-center text-sm"><span class="badge badge-sm bg-gradient-' . $badgeColor . '">' . $status . '</span></div>';
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="d-flex px-3 py-1 justify-content-center align-items-center"><a href="' . route('category.edit',['category' => $row->id]). '" class=""><p class="text-sm font-weight-bold mb-0">Edit</p></a>
                <form action="'. route('category.destroy', ['category' => $row]) .'" method="POST">
                                            '.csrf_field().'
                                            '.method_field('DELETE').'
                                        <a href="'. route('category.destroy', ['category' => $row]) .'"><p class="text-sm font-weight-bold mb-0 ps-2">Delete</p></a>
                                        </form></div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

}
