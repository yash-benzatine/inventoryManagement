<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','store']]);
         $this->middleware('permission:category-create', ['only' => ['create','store']]);
         $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view("admin.category.index");
    }

    public function create()
    {
        $categories = Category::where('cat_id', '=', 0)->get();
        return view('admin.category.create', compact('categories'));
    }

    public function store(Request $request)
    {
      try {
        // Validate the incoming request data
        $validatedData = Validator::make($request->all() ,[
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string', // You might adjust this validation rule as needed
            'cat_id' => [
                'required_if:cat_id,0',
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
            $category->cat_id = 0;
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
        try {
            $validatedData = Validator::make($request->all(), [
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
                $message = 'Sub category updated successfully.';
            }else{
                $route = 'category.index';
                $message = 'Category updated successfully.';
            }
            if($category->save()) {
                return redirect()->route($route)->with(['message' => $message, 'alert-type' => 'success']);
            }else{
                return redirect()->back()->with(['message' => 'Data not updated successfully.', 'alert-type' => 'error']);
            }
            } catch (ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with(['message'=> $e->getMessage(), 'alert-type' => 'warning']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($categoryId)
    {
        $category = Category::where('id', $categoryId)->first();
        $category->delete();
        return redirect()->back()->with(['message'=>'Category deleted successfully', 'alert-type' => 'success']);
    }

    public function getData()
    {
        $data = Category::select('*')->where('cat_id', '=', 0);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                $status = ($row->status == 1) ? 'active' : 'inactive';
                $badgeColor = ($row->status == 1) ? 'success' : 'danger';

                return '<span class="badge badge-pill badge-sm badge-' . $badgeColor . '">' . $status . '</span>';
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="d-flex px-3 py-1 align-items-center"><a href="' . route('category.edit',['category' => $row->id]). '" class="btn btn-primary btn-icon-only mx-2" title="Edit Category"><span class="btn-inner--icon"><i class="fab fa fa-edit"></i></a>
                <form action="'. route('category.destroy', ['category' => $row]) .'" method="POST">
                                            '.csrf_field().'
                                            '.method_field('DELETE').'
                                        <a href="'. route('category.delete', $row->id) .'" class="btn btn-danger btn-icon-only" title="Delete Category"><span class="btn-inner--icon"><i class="fab fa fa-trash"></i></a>
                                        </form></div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
}
