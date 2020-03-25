<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Product;
use App\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check() === true) {
            return redirect()->route('admin.home');
        }

        return view('admin.index');
    }

    public function home()
    {
        $managers = User::managers()->count();
        $sellers = User::sellers()->count();
        $usersTotal = User::all()->count();

        $productsAvailable = Product::available()->count();
        $productsUnavailable = Product::unavailable()->count();
        $productsTotal = Product::all()->count();

        $products = Product::orderBy('id', 'DESC')->limit(3)->get();

        return view('admin.dashboard', [
            'managers' => $managers,
            'sellers' => $sellers,
            'usersTotal' => $usersTotal,
            'productsAvailable' => $productsAvailable,
            'productsUnavailable' => $productsUnavailable,
            'productsTotal' => $productsTotal,
            'products' => $products
        ]);
    }


    public function login(Request $request)
    {
        if (in_array('', $request->only('email', 'password'))) {
            $json['message'] = $this->message->error('Ooops, informe todos os dados para efetuar o login')->render();
            return response()->json($json);
        }

        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $json['message'] = $this->message->error('Ooops, informe um e-mail válido')->render();
            return response()->json($json);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!Auth::attempt($credentials)) {
            $json['message'] = $this->message->error('Ooops, usuário e senha não conferem')->render();
            return response()->json($json);
        }

        $json['redirect'] = route('admin.home');
        return response()->json($json);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
