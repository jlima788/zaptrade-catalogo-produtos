@extends('admin.master.master')

@section('content')
<section class="dash_content_app">

    <header class="dash_content_app_header">
        <h2 class="icon-user-plus">Novo Cliente</h2>

        <div class="dash_content_app_header_actions">
            <nav class="dash_content_app_breadcrumb">
                <ul>
                    <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="separator icon-angle-right icon-notext"></li>
                    <li><a href="{{ route('admin.users.index') }}">Usuários</a></li>
                    <li class="separator icon-angle-right icon-notext"></li>
                    <li><a href="{{ route('admin.users.create') }}" class="text-orange">Novo Usuário</a></li>
                </ul>
            </nav>
        </div>
    </header>

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
            </ul>

            <form class="app_form" action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data" autocomplete="false">
                @csrf

                <div class="nav_tabs_content">
                    <div id="data">
                        <div class="label_gc">
                            <span class="legend">Perfil:</span>
                            @foreach($roles as $role)
                                <label class="label">
                                    <input type="checkbox" name="acl_{{$role->id}}" {{ ($role->can == 1 ? 'checked' : '') }}>
                                    <span>{{$role->name}}</span>
                                </label>
                            @endforeach
                        </div>

                        <label class="label">
                            <span class="legend">*Nome:</span>
                            <input type="text" name="name" placeholder="Nome Completo" value="{{ old('name') }}"/>
                        </label>

                        <div class="label_g2">
                            <label class="label">
                                <span class="legend">*E-mail:</span>
                                <input type="email" name="email" placeholder="Melhor e-mail"
                                       value="{{ old('email') }}"/>
                            </label>

                            <label class="label">
                                <span class="legend">Senha:</span>
                                <input type="password" name="password" placeholder="Senha de acesso"
                                       value=""/>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="text-right mt-2">
                    <button class="btn btn-large btn-green icon-check-square-o" type="submit">Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection