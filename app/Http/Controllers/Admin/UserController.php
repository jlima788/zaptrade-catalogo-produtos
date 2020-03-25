<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User as UserRequest;
use App\User;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        foreach ($roles as $role){
            $role->can = false;
        }
        return view('admin.users.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $userCreate = User::create($request->all());

        $rolesRequest = $request->all();
        $roles = null;
        foreach ($rolesRequest as $key => $value){
            if(Str::is('acl_*', $key) == true){
                $roles[] = Role::where('id', ltrim($key, 'acl_'))->first();
            }
        }

        if(!empty($roles)){
            $userCreate->syncRoles($roles);
        }else{
            $userCreate->syncRoles(null);
        }

        return redirect()->route('admin.users.edit', [
            'user' => $userCreate->id
        ])->with(['color' => 'green', 'message' => 'Usuário cadastrado com sucesso!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        $roles = Role::all();

        foreach ($roles as $role) {
            if ($user->hasRole($role->name)) {
                $role->can = true;
            } else {
                $role->can = false;
            }
        }

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::where('id', $id)->first();

        $user->setManagerAttribute($request->manager);
        $user->setSellerAttribute($request->seller);

        $user->fill($request->all());

        if (!$user->save()) {
            return redirect()->back()->withInput()->withErrors();
        }

        $rolesRequest = $request->all();
        $roles = null;
        foreach ($rolesRequest as $key => $value) {
            if (Str::is('acl_*', $key) == true) {
                $roles[] = Role::where('id', ltrim($key, 'acl_'))->first();
            }
        }

        if (!empty($roles)) {
            $user->syncRoles($roles);
        } else {
            $user->syncRoles(null);
        }

        return redirect()->route('admin.users.edit', [
            'user' => $user->id
        ])->with(['color' => 'green', 'message' => 'Usuário atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->hasPermissionTo('Remover Usuário')){
            throw new UnauthorizedException('403', 'Você não tem permissão para acessar este recurso!');
        }

        $user = User::where('id', $id)->first();
        $user->delete();

        return redirect()->route('admin.users.index')->with(['color' => 'orange', 'message' => 'Usuário removido com sucesso!']);
    }
}
