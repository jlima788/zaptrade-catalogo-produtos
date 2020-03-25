@extends('admin.master.master')

@section('content')
    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-shopping-cart">Listagem</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.products.index') }}">Produtos</a></li>
                    </ul>
                </nav>

                <a href="{{ route('admin.products.create') }}" class="btn btn-orange icon-home ml-1">Criar Produto</a>
            </div>
        </header>

        <div class="dash_content_app_box">
            <div class="dash_content_app_box_stage">
                <table id="dataTable" class="nowrap stripe" width="100" style="width: 100% !important;">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome do Produto</th>
                        <th>Preço</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td><a href="{{ route('admin.products.edit', ['product' => $product->id]) }}" class="text-orange">{{ $product->title }}</a></td>
                            <td>R$ {{ $product->sale_price }}</td>
                            <td>{{ ($product->status == '1' ? 'Disponível' : 'Indiponível')  }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection