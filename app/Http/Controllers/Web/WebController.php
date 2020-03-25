<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WebController extends Controller
{
    public function home()
    {
        $products = Product::available()->orderBy('id', 'DESC')->paginate(6);

        return view('site.home', [
            'products' => $products
        ]);
    }

    public function buyProduct(Request $request)
    {
        $product = Product::where('slug', $request->slug)->first();

        return view('site.product', [
            'product' => $product,
        ]);
    }
}
