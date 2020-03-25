@extends('admin.master.master')

@section('content')
    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-cart-plus">Editar Produto</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.products.index') }}">Produtos</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        @include('admin.products.filter')

        <div class="dash_content_app_box">

            <div class="nav">

                @if($errors->all())
                    @foreach($errors->all() as $error)
                        @message(['color' => 'orange'])
                        <p class="icon-asterisk">{{ $error }}</p>
                        @endmessage
                    @endforeach
                @endif

                @if(session()->exists('message'))
                    @message(['color' => session()->get('color')])
                    <p class="icon-asterisk">{{ session()->get('message') }}</p>
                    @endmessage
                @endif

                <ul class="nav_tabs">
                    <li class="nav_tabs_item">
                        <a href="#data" class="nav_tabs_item_link active">Dados Cadastrais</a>
                    </li>
                    <li class="nav_tabs_item">
                        <a href="#images" class="nav_tabs_item_link">Imagens</a>
                    </li>
                </ul>

                <form action="{{ route('admin.products.update', ['product' => $product->id]) }}" method="post"
                      class="app_form"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="nav_tabs_content">
                        <div id="data">
                            @role('Gerente')
                            <label class="label">
                                <span class="legend">Usuário:</span>
                                {{--                                {{dd($users)}}--}}
                                <select name="user" class="select2">
                                    <option value="">Selecione o usuário</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ ($user->id == $product->user ? 'selected' : '') }}>{{ $user->name }}
                                            ({{ $user->manager == '1' ? 'Gerente' : 'Vendedor' }})
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            @else
                                <input type="hidden" name="user"
                                       value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">
                                @endrole

                                <label class="label">
                                    <span class="legend">Título:</span>
                                    <input type="text" name="title" value="{{ old('title') ?? $product->title }}">
                                </label>

                                <label class="label">
                                    <span class="legend">Descrição do Imóvel:</span>
                                    <textarea name="description" cols="30" rows="10"
                                              class="mce">{{ old('description') ?? $product->description }}</textarea>
                                </label>

                                <label class="label">
                                    <span class="legend">Valor de Venda:</span>
                                    <input type="tel" name="sale_price" class="mask-money"
                                           value="{{ old('sale_price') ?? $product->sale_price }}"/>
                                </label>

                                @can('Alterar Status')
                                    <div class="label_g2">
                                        <label class="label">
                                            <span class="legend">Status:</span>
                                            <select name="status" class="select">
                                                <option value="1" {{ (old('status') == '1' ? 'selected' : ($product->status == true ? 'selected' : '')) }}>
                                                    Disponível
                                                </option>
                                                <option value="0" {{ (old('status') == '0' ? 'selected' : ($product->status == false ? 'selected' : '')) }}>
                                                    Indisponível
                                                </option>
                                            </select>
                                        </label>
                                    </div>
                                @else
                                    <input type="hidden" name="status" value="{{ $product->status }}">
                                @endcan

                        </div>

                        <div id="images" class="d-none">
                            <label class="label">
                                <span class="legend">Imagens</span>
                                <input type="file" name="files[]" multiple>
                            </label>

                            <div class="content_image"></div>

                            <div class="product_image">
                                @foreach($product->images()->get() as $image)
                                    <div class="product_image_item">
                                        <img src="{{ $image->url_cropped }}" alt="">
                                        <div class="product_image_actions">
                                            <a href="javascript:void(0)"
                                               class="btn btn-small {{ ($image->cover == true ? 'btn-green' : '') }} icon-check icon-notext image-set-cover"
                                               data-action="{{ route('admin.products.imageSetCover', ['image' => $image->id]) }}"></a>
                                            <a href="javascript:void(0)"
                                               class="btn btn-red btn-small icon-times icon-notext image-remove"
                                               data-action="{{ route('admin.products.imageRemove', ['image' => $image->id]) }}"></a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="text-right mt-2">
                        <a href="javascript:void(0)" data-action="{{ route('admin.products.destroy', [ 'product' => $product->id]) }}"
                           class="btn btn-large btn-orange icon-trash-o product-remove">Remover Produto</a>
                        <button class="btn btn-large btn-green icon-check-square-o">Atualizar Produto</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('input[name="files[]"]').change(function (files) {

                $('.content_image').text('');

                $.each(files.target.files, function (key, value) {
                    var reader = new FileReader();
                    reader.onload = function (value) {
                        $('.content_image').append(
                            '<div class="product_image_item">' +
                            '<div class="embed radius" ' +
                            'style="background-image: url(' + value.target.result + '); background-size: cover; background-position: center center;">' +
                            '</div>' +
                            '</div>');
                    };
                    reader.readAsDataURL(value);
                });
            });

            $('.image-set-cover').click(function (event) {
                event.preventDefault();

                var button = $(this);

                $.post(button.data('action'), {}, function (response) {
                    if (response.success === true) {
                        $('.product_image').find('a.btn-green').removeClass('btn-green');
                        button.addClass('btn-green');
                    }
                }, 'json');
            });

            $('.image-remove').click(function (event) {
                event.preventDefault();

                var button = $(this);

                $.ajax({
                    url: button.data('action'),
                    type: 'DELETE',
                    dataType: 'json',
                    success: function (response) {

                        if (response.success === true) {
                            button.closest('.product_image_item').fadeOut(function () {
                                $(this).remove();
                            });
                        }
                    }
                })
            });

            $('.product-remove').click(function (event) {
                event.preventDefault();

                var button = $(this);

                $.ajax({
                    url: button.data('action'),
                    type: 'DELETE',
                    dataType: 'json',
                    success: function (response) {
                        if(response.message) {
                            window.location.href = response.redirect;
                            ajaxMessage(response.message, 100);
                        }
                    }
                })
            });

            // AJAX RESPONSE
            var ajaxResponseBaseTime = 100;

            function ajaxMessage(message, time) {
                var ajaxMessage = $(message);

                ajaxMessage.append("<div class='message_time'></div>");
                ajaxMessage.find(".message_time").animate({"width": "100%"}, time * 1000, function () {
                    $(this).parents(".message").fadeOut(200);
                });

                $(".ajax_response").append(ajaxMessage);
            }
        });
    </script>
@endsection