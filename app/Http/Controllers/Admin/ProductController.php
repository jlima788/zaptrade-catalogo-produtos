<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Product;
use App\Http\Requests\Admin\Product as ProductRequest;
use App\ProductImage;
use App\Support\Cropper;
use App\User;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Role;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::user()->hasPermissionTo('Listar Produtos')){
            throw new UnauthorizedException('403', 'Você não tem permissão para acessar este recurso!');
        }

        if(Auth::user()->hasRole('Gerente')){
            $products = Product::orderBy('id', 'DESC')->get();
        }

        if(Auth::user()->hasRole('Vendedor')){
            $products = Product::orderBy('id', 'DESC')->where('user', Auth::user()->id)->get();
        }

        return view('admin.products.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Cadastrar Produto')){
            throw new UnauthorizedException('403', 'Você não tem permissão para acessar este recurso!');
        }

        $users = User::orderBy('name')->get();
        return view('admin.products.create', [
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        if(!Auth::user()->hasPermissionTo('Cadastrar Produto')){
            throw new UnauthorizedException('403', 'Você não tem permissão para acessar este recurso!');
        }

        $createProduct = Product::create($request->all());
        $createProduct->setSlug();

        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if($validator->fails() === true) {
            return redirect()->back()->withInput()->with(['color' => 'orange', 'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.']);
        }

        if($request->allFiles()) {
            foreach($request->allFiles()['files'] as $image) {
                $productImage = new ProductImage();
                $productImage->product = $createProduct->id;
                $productImage->path = $image->store('products/' . $createProduct->id);
                $productImage->save();
                unset($productImage);
            }
        }

        return redirect()->route('admin.products.edit', [
            'product' => $createProduct->id
        ])->with(['color' => 'green', 'message' => 'Produto cadastrado com sucesso!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Editar Produto')){
            throw new UnauthorizedException('403', 'Você não tem permissão para acessar este recurso!');
        }

        if(Auth::user()->hasRole('Gerente')){
            $product = Product::where('id', $id)->first();
        }

        if(Auth::user()->hasRole('Vendedor')){
            $product = Product::where('id', $id)->where('user', Auth::user()->id)->first();
        }

        if(!$product){
            throw new UnauthorizedException('403', 'Você não tem permissão para acessar este recurso!');
        }

        $users = User::orderBy('name')->get();

        return view('admin.products.edit', [
            'product' => $product,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        if(!Auth::user()->hasPermissionTo('Editar Produto')){
            throw new UnauthorizedException('403', 'Você não tem permissão para acessar este recurso!');
        }

        $product = Product::where('id', $id)->first();
        $product->fill($request->all());

        $product->save();
        $product->setSlug();

        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if($validator->fails() === true) {
            return redirect()->back()->withInput()->with(['color' => 'orange', 'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.']);
        }

        if($request->allFiles()) {
            foreach($request->allFiles()['files'] as $image) {
                $productImage = new ProductImage();
                $productImage->product = $product->id;
                $productImage->path = $image->store('products/' . $product->id);
                $productImage->save();
                unset($productImage);
            }
        }

        return redirect()->route('admin.products.edit', [
            'product' => $product->id
        ])->with(['color' => 'green', 'message' => 'Produto alterado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->hasPermissionTo('Remover Produto')){
            throw new UnauthorizedException('403', 'Você não tem permissão para acessar este recurso!');
        }

        $product = Product::where('id', $id)->first();
        $product->delete();

        $json['redirect'] = route('admin.products.index');
        $json['message'] = $this->message->error('Produto removido com sucesso!')->render();

        return response()->json($json);
    }

    public function imageSetCover(Request $request)
    {
        $imageSetCover = ProductImage::where('id', $request->image)->first();
        $allImage = ProductImage::where('product', $imageSetCover->product)->get();

        foreach($allImage as $image) {
            $image->cover = null;
            $image->save();
        }

        $imageSetCover->cover = true;
        $imageSetCover->save();

        $json = [
            'success' => true
        ];

        return response()->json($json);
    }

    public function imageRemove(Request $request)
    {
        $imageDelete = ProductImage::where('id', $request->image)->first();

        Storage::delete($imageDelete->path);
        Cropper::flush($imageDelete->path);
        $imageDelete->delete();

        $json = [
            'success' => true
        ];
        return response()->json($json);
    }
}
