@extends('admin.master.master')

@section('content')
    <div style="flex-basis: 100%;">
        <section class="dash_content_app">
            <header class="dash_content_app_header">
                <h2 class="icon-tachometer">Dashboard</h2>
            </header>

            <div class="dash_content_app_box justify-content-start">
                <section class="app_dash_home_stats">
                    <article class="control radius">
                        <h4 class="icon-users">Usuários</h4>
                        <p><b>Gerentes:</b> {{ $managers }}</p>
                        <p><b>Vendedores:</b> {{ $sellers }}</p>
                        <p><b>Total:</b> {{ $usersTotal }}</p>
                    </article>

                    <article class="blog radius">
                        <h4 class="icon-home">Produtos</h4>
                        <p><b>Disponíveis:</b> {{ $productsAvailable }}</p>
                        <p><b>Indisponíveis:</b> {{ $productsUnavailable }}</p>
                        <p><b>Total:</b> {{ $productsTotal }}</p>
                    </article>
                </section>
            </div>
        </section>

        <section class="dash_content_app" style="margin-top: 40px;">
            <header class="dash_content_app_header">
                <h2 class="icon-tachometer">Últimos Produtos Cadastrados</h2>
            </header>

            <div class="dash_content_app_box">
                <div class="dash_content_app_box_stage">
                    <div class="realty_list">
                        @if(!empty($products))
                            @foreach($products as $product)
                                <div class="realty_list_item mb-2">
                                    <div class="realty_list_item_actions_stats">
                                        <img src="{{ $product->cover() }}" alt="">
                                        <ul>
                                            <li>Venda: R$ {{ $product->sale_price }}</li>
                                        </ul>
                                    </div>

                                    <div class="realty_list_item_content">
                                        <h4>#{{ $product->id }} - {{ $product->title }}
                                            - {{ ($product->status == '1' ? 'Status: Disponível' : 'Status: Indisponível' ) }}</h4>

                                        <div class="realty_list_item_card">
                                            <div class="realty_list_item_card_image">
                                                <span class="icon-list"></span>
                                            </div>
                                            <div class="realty_list_item_card_content">
                                                <span class="realty_list_item_description_title">Descrição:</span>
                                                <span class="realty_list_item_description_content">{{ $product->description }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="no-content">Não foram encontrados registros!</div>
                        @endif

                    </div>
                </div>
        </section>
    </div>
@endsection