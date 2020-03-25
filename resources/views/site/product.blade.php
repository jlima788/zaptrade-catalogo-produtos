@extends('site.master.master')

@section('content')
    <section class="main_property">
        <div class="main_property_header py-5 bg-light text-xl-center">
            <div class="container">
                <h1 class="text-front">{{ $product->title }}</h1>
            </div>
        </div>
        <div class="main_property_content py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div id="carouselProperty" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">

                                @if($product->images()->get()->count())
                                    @foreach($product->images()->get() as $image)
                                        <li data-target="#carouselProperty"
                                            data-slide-to="{{ $loop->iteration }}" {!! ($loop->iteration == 1 ? 'class="active"' : '') !!}></li>
                                    @endforeach
                                @endif

                            </ol>

                            <div class="carousel-inner">

                                @if($product->images()->get()->count())
                                    @foreach($product->images()->get() as $image)

                                        <div class="carousel-item {{ ($loop->iteration == 1 ? 'active' : '') }}">
                                            <a href="{{ $image->getUrlCroppedAttribute() }}" data-toggle="lightbox"
                                               data-gallery="property-gallery" data-type="image">
                                                <img src="{{ $image->getUrlCroppedAttribute() }}"
                                                     class="d-block w-100"
                                                     alt="{{ $product->title }}">
                                            </a>
                                        </div>

                                    @endforeach
                                @endif
                            </div>
                            <a class="carousel-control-prev" href="#carouselProperty" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Anterior</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselProperty" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Próximo</span>
                            </a>
                        </div>

                        <div class="main_property_price pt-4 text-muted">
                            <h4 class="main_property_price_small">Valor: R$ {{ $product->sale_price }}</h4>
                        </div>

                        <div class="main_property_content_description">
                            <h2 class="text-front">Descrição:</h2>
                            {!! $product->description !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection