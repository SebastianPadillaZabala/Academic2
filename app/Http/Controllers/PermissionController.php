<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Http\Requests\Permission\StoreRequest;
use App\Http\Requests\Permission\UpdateRequest;
use App\Models\Role;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*
    public function __construct()
    {
        $this->middleware('role:' . config('app.admin_role'));
    }}*/
    public function index()
    {
        $this->authorize('index',Role::class);
        return view('backoffice.pages.permission.index',[
            'permissions'=>Permission::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Role::class);
        return view('backoffice.pages.permission.create',[
            'roles'=>Role::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, Permission $permission)
    {
        $permission = $permission->store($request);

        $user = Auth::user();
        $info = [
            'IP' => $request->getClientIp(),
            'id usuario' => $user->id,
            'tipo usuario' => $user->tipo,
            'nuevo registro' => $permission,
        ];
        Log::channel('mydailylogs')->info('Crear Permiso: ', $info);

        return redirect()->route('backoffice.permission.show',$permission);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        $this->authorize('view', $permission);
        return view('backoffice.pages.permission.show',[
            'permission' => $permission
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        $this->authorize('update', $permission);
        return view('backoffice.pages.permission.edit',[
            'permission'=>$permission,
            'roles'=>Role::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRequest  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Permission $permission)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $this->authorize('delete', $permission);
        $role = $permission->role;
        $permissionAnt = $permission;
        $permission->delete();

        $user = Auth::user();
        $info = [
            'id usuario' => $user->id,
            'tipo usuario' => $user->tipo,
            'antiguo registro' => $permissionAnt,
        ];
        Log::channel('mydailylogs')->info('Eliminar Permiso: ', $info);

        return redirect()->route('backoffice.role.show',$role);
    }
}
