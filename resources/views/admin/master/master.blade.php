<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0">

    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/reset.css')) }}"/>
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/libs.css')) }}">
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/boot.css')) }}"/>
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/style.css')) }}"/>

@hasSection('css')
    @yield('css')
@endif

<!-- Favicons -->
    <link rel="apple-touch-icon" href="{{ url(asset('site/apple-touch-icon.png')) }}" sizes="180x180">
    <link rel="icon" href="{{ url(asset('site/favicon-32x32.png')) }}" sizes="32x32" type="image/png">
    <link rel="icon" href="{{ url(asset('site/favicon-16x16.png')) }}" sizes="16x16" type="image/png">
    <link rel="manifest" href="{{ url(asset('site/manifest.json')) }}">
    <link rel="mask-icon" href="{{ url(asset('site/safari-pinned-tab.svg')) }}" color="#5bbad5">
    <link rel="icon" href="{{ url(asset('site/favicon.ico')) }}">
    <meta name="msapplication-config" content="{{ url(asset('site/browserconfig.xml')) }}">
    <meta name="theme-color" content="#5bbad5">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Zaptrade - Site Control</title>
</head>
<body>

<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <p class="ajax_load_box_title">Aguarde, carregando...</p>
    </div>
</div>

<div class="ajax_response"></div>

<div class="dash">
    <aside class="dash_sidebar">
        <article class="dash_sidebar_user">
            <img class="dash_sidebar_user_thumb" src="{{ url(asset('backend/assets/images/avatar.jpg')) }}" alt=""
                 title=""/>

            <h1 class="dash_sidebar_user_name">
                <a href="">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a>
            </h1>
        </article>

        <ul class="dash_sidebar_nav">
            <li class="dash_sidebar_nav_item {{ isActive('admin.home') }}">
                <a class="icon-tachometer" href="{{ route('admin.home') }}">Dashboard</a>
            </li>
            @role('Gerente')
            <li class="dash_sidebar_nav_item {{ isActive('admin.users') }}"><a
                        class="icon-users" href="{{ route('admin.users.index') }}">Usuários</a>
                <ul class="dash_sidebar_nav_submenu">
                    <li class="{{ isActive('admin.users.index') }}"><a href="{{ route('admin.users.index') }}">Ver
                            Todos</a></li>
                    <li class="{{ isActive('admin.users.create') }}"><a href="{{ route('admin.users.create') }}">Criar
                            Novo</a></li>
                </ul>
            </li>
            @endrole
            <li class="dash_sidebar_nav_item {{ isActive('admin.products') }}"><a class="icon-cart-plus"
                                                                                  href="#">Produtos</a>
                <ul class="dash_sidebar_nav_submenu">
                    @can('Listar Produtos')
                    <li class="{{ isActive('admin.products.index') }}"><a
                                href="{{ route('admin.products.index') }}">Ver Todos</a></li>
                    @endcan
                    <li class="{{ isActive('admin.products.create') }}"><a
                                href="{{ route('admin.products.create') }}">Criar Novo</a></li>
                </ul>
            </li>

            @can('Ver Configurações')
            <li class="dash_sidebar_nav_item {{ isActive('admin.permission') }} {{ isActive('admin.role') }}"><a class="icon-cogs"
                                                                                  href="{{ route('admin.role.index') }}">Configurações</a>
                <ul class="dash_sidebar_nav_submenu">
                    <li class="{{ isActive('admin.role.index') }}"><a
                                href="{{ route('admin.role.index') }}">Perfis</a></li>
                    <li class="{{ isActive('admin.permissions.index') }}"><a
                                href="{{ route('admin.permissions.index') }}">Permissões</a></li>
                </ul>
            </li>
            @endcan
            <li class="dash_sidebar_nav_item"><a class="icon-reply" href="{{ route('web.home') }}" target="_blank">Ver
                    Site</a></li>
            <li class="dash_sidebar_nav_item"><a class="icon-sign-out on_mobile" href="{{ route('admin.logout') }}"
                                                 target="_blank">Sair</a></li>
        </ul>

    </aside>

    <section class="dash_content">

        <div class="dash_userbar">
            <div class="dash_userbar_box">
                <div class="dash_userbar_box_content">
                    <span class="icon-align-justify icon-notext mobile_menu transition btn btn-green"></span>
                    <h1 class="transition">
                        <a href="">Zaptrade<b>Admin</b></a>
                    </h1>
                    <div class="dash_userbar_box_bar no_mobile">
                        <a class="text-red icon-sign-out" href="{{ route('admin.logout') }}">Sair</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="dash_content_box">
            @yield('content')
        </div>
    </section>
</div>


<script src="{{ url(mix('backend/assets/js/jquery.js')) }}"></script>
<script src="{{ url(asset('backend/assets/js/tinymce/tinymce.min.js')) }}"></script>
<script src="{{ url(mix('backend/assets/js/libs.js')) }}"></script>
<script src="{{ url(mix('backend/assets/js/scripts.js')) }}"></script>

@hasSection('js')
    @yield('js')
@endif

</body>
</html>