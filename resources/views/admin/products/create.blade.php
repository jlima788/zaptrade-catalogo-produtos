@extends('admin.master.master')

@section('content')
    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-search">Cadastrar Novo Produto</h2>

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

                <ul class="nav_tabs">
                    <li class="nav_tabs_item">
                        <a href="#data" class="nav_tabs_item_link active">Dados Cadastrais</a>
                    </li>
                    <li class="nav_tabs_item">
                        <a href="#images" class="nav_tabs_item_link">Imagens</a>
                    </li>
                </ul>

                <form action="{{ route('admin.products.store') }}" method="post" class="app_form"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="nav_tabs_content">
                        <div id="data">
                            @role('Gerente')
                                <label class="label">
                                    <span class="legend">Usuário:</span>
                                    <select name="user" class="select2">
                                        <option value="">Selecione o usuário</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}
                                                ({{ $user->manager == '1' ? 'Gerente' : 'Vendedor' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </label>
                            @else
                                <input type="hidden" name="user" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">
                            @endrole

                                <label class="label">
                                <span class="legend">Título:</span>
                                    <input type="text" name="title" value="{{ old('title') }}">
                                </label>

                                <label class="label">
                                    <span class="legend">Descrição do Produto:</span>
                                    <textarea name="description" cols="30" rows="10"
                                              class="mce">{{ old('description') }}</textarea>
                                </label>

                                <label class="label">
                                    <span class="legend">Valor de Venda:</span>
                                    <input type="tel" name="sale_price" class="mask-money"
                                           value="{{ old('sale_price') }}"/>
                                </label>

                                @can('Alterar Status')
                                    <div class="label_g2">
                                        <label class="label">
                                            <span class="legend">Status:</span>
                                            <select name="status" class="select">
                                                <option value="1" {{ (old('status') == '1' ? 'selected' : '') }}>
                                                    Disponível
                                                </option>
                                                <option value="0" {{ (old('status') == '0' ? 'selected' : '') }}>
                                                    Indisponível
                                                </option>
                                            </select>
                                        </label>
                                    </div>
                                @else
                                    <input type="hidden" name="status" value="0">
                                @endcan

                        </div>

                        <div id="images" class="d-none">
                            <label class="label">
                                <span class="legend">Imagens</span>
                                <input type="file" name="files[]" multiple>
                            </label>

                            <div class="content_image"></div>
                        </div>
                    </div>

                    <div class="text-right mt-2">
                        <button class="btn btn-large btn-green icon-check-square-o">Criar Produto</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(function () {
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
        });
    </script>
@endsection