<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use DataTables;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class RoleController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $roles = Role::orderBy('id','DESC')->paginate(5);
        return view('admin.roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $permissions = Permission::get();
        return view('admin.roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:roles,name',
                'permissions' => 'required',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $role = Role::create(['name' => $request->input('name')]);
            $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();
            $role->syncPermissions($permissions);

            return redirect()->route('roles.index')->with(['message'=> 'Role created successfully', 'alert-type' => 'success']);
        } catch (ValidationException $e) {
            // Handle validation errors
            return back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions
            return back()->with(['message' => $e->getMessage(), 'alert-type' => 'warning']);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return view('admin.roles.show',compact('role','rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $role = Role::find($id);
        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return view('admin.roles.edit',compact('role','permissions','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'permissions' => 'required',
        ]);

        $role = Role::find($id);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with(['message' => 'Role updated successfully', 'alert-type'=>'success']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->back()
                        ->with(['message'=> 'Role deleted successfully', 'alert-type'=> 'success']);
    }

    public function getData()
    {
        $data = Role::select('*');
        return Datatables::of($data)
            ->addIndexColumn()
             ->addColumn('permission', function ($role) {
                $role = Role::find($role->id);
                $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
                    ->where("role_has_permissions.role_id",$role->id)
                    ->get();
                 $permissionNames = '<div style="text-align: left;">'; // Initialize a row

                foreach ($rolePermissions as $index => $permission) {
                    if ($index > 0 && $index % 8 == 0) {
                        // Start a new row after every 4 permissions (adjust as needed)
                        $permissionNames .= '</div><div style="text-align: left;">';
                    }

                    // Append each permission name wrapped in a span to the $permissionNames string
                    $permissionNames .= '<span class="badge badge-primary">' . $permission->name . '</span>';
                }

                $permissionNames .= '</div>'; // Close the last row
                return $permissionNames;
            })
            ->addColumn('action', function ($role) {
                $actionBtn = '<form action="' . route('roles.destroy', $role->id) . '" method="post" class="my-1">' .
                                csrf_field() .
                                method_field('DELETE');

                if ($role->name != 'Super Admin') {
                    if (Gate::allows('role-edit')) {
                        $actionBtn .= '<a href="' . route('roles.edit', $role->id) . '" class="btn btn-primary btn-icon-only mx-2" title="Role Edit"><span class="btn-inner--icon"><i class="fab fa fa-edit"></i></a>';
                    }

                    if (Gate::allows('role-delete')) {
                        $actionBtn .= '<button type="submit" class="btn btn-danger btn-icon-only" onclick="return confirm(\'Do you want to delete this role?\');" title="Delete Role"><span class="btn-inner--icon"><i class="fab fa fa-trash"></i></button>';
                    }
                }

                $actionBtn .= '</form>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'permission'])
            ->make(true);
    }
}
