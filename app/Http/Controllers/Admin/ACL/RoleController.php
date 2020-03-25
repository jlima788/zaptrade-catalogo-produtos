<?php

namespace App\Http\Controllers\Admin\ACL;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::user()->hasPermissionTo('Ver Configurações')){
            throw new UnauthorizedException('403', 'Você não tem permissão para acessar este recurso!');
        }

        $roles = Role::all();

        return view('admin.roles.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Permission::where('name', $request->name)->get();

        if ($role->count() > 0) {
            return redirect()->back()->withInput()->with([
                'color' => 'orange',
                'message' => 'Ooops, O nome desse perfil já está em uso'
            ]);
        }

        $role = new Role();
        $role->name = $request->name;
        $role->save();

        return redirect()->route('admin.role.index')->with([
            'color' => 'green',
            'message' => 'Perfil cadastrado com sucesso!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::where('id', $id)->first();

        return view('admin.roles.edit', [
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Permission::where('name', $request->name)->where('id', '!=', $id)->get();

        if ($role->count() > 0) {
            return redirect()->back()->withInput()->with([
                'color' => 'orange',
                'message' => 'Ooops, O nome desse perfil já está em uso'
            ]);
        }

        $role = Role::where('id', $id)->first();
        $role->name = $request->name;
        $role->save();

        return redirect()->route('admin.role.index')->with([
            'color' => 'green',
            'message' => 'Perfil atualizado com sucesso!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::where('id', $id)->first();
        $role->delete();

        return redirect()->route('admin.role.index')->with(['color' => 'orange', 'message' => 'Perfil removido com sucesso!']);
    }

    public function permissions($role)
    {
        $role = Role::where('id', $role)->first();

        $permissions = Permission::all();

        foreach ($permissions as $permission) {
            if ($role->hasPermissionTo($permission->name)) {
                $permission->can = true;
            } else {
                $permission->can = false;
            }
        }

        return view('admin.roles.permissions', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function permissionsSync(Request $request, $role)
    {
        $permissionsRequest = $request->except(['_token', '_method']);

        foreach ($permissionsRequest as $key => $value) {
            $permissions[] = Permission::where('id', $key)->first();
        }

        $role = Role::where('id', $role)->first();
        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions(null);
        }

        return redirect()->route('admin.role.permissions', [
            'role' => $role->id
        ]);
    }
}
