@extends('site.master.master')

@section('content')

    <section class="main_properties py-5">
        <div class="container">
            <div class="row">
                @if($products->count())
                    @foreach($products as $product)
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <article class="card main_properties_item">
                                <div class="img-responsive-16by9">
                                    <a href="{{ route('web.buyProduct', ['product' => $product->slug]) }}">
                                        <img src="{{ $product->cover() }}" class="card-img-top"
                                             alt="{{ $product->title }}" title="{{ $product->title }}">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h3><a href="{{ route('web.buyProduct', ['product' => $product->slug]) }}"
                                           class="text-front">{{ str_limit($product->title, 20, $end='...') }}</a>
                                    </h3>
                                    <p class="main_properties_item_type">{!! str_limit($product->description, 140) !!}</p>
                                    <p class="main_properties_price text-front">R$ {{ $product->sale_price }}</p>
                                </div>
                            </article>
                        </div>
                    @endforeach
                @endif
            </div>
            {!! $products->links('site.includes.paginator') !!}
        </div>
    </section>
@endsection