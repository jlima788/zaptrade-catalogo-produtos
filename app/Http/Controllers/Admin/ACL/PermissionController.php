<?php

namespace App\Http\Controllers\Admin\ACL;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
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

        $permissions = Permission::all();

        return view('admin.permissions.index', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permission = Permission::where('name', $request->name)->get();

        if($permission->count() > 0){
            return redirect()->back()->withInput()->with(['color' => 'orange', 'message' => 'Ooops, Permissão já está em uso']);
        }

        $permission = new Permission();
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('admin.permissions.index')->with(['color' => 'green', 'message' => 'Permissão cadastrada com sucesso!']);
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
        $permission = Permission::where('id', $id)->first();

        return view('admin.permissions.edit', [
            'permission' => $permission
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
        $permission = Permission::where('name', $request->name)->where('id', '!=', $id)->get();

        if($permission->count() > 0){
            return redirect()->back()->withInput()->with(['color' => 'orange', 'message' => 'Ooops, Permissão já está em uso']);
        }

        $permission = Permission::where('id', $id)->first();
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('admin.permissions.index')->with(['color' => 'green', 'message' => 'A permissão foi alterada com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::where('id', $id)->first();
        $permission->delete();

        return redirect()->route('admin.permissions.index')->with(['color' => 'orange', 'message' => 'Permissão removida com sucesso!']);
    }
}
