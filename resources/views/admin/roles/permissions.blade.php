@extends('admin.master.master')

@section('content')
    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-pencil-square-o">Permissões para: {{ $role->name }}</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.role.index') }}" class="text-orange">Perfis</a></li>
                    </ul>
                </nav>
            </div>
        </header>

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

        <div class="dash_content_app_box">
            <div class="dash_content_app_box_stage">
                <h3 class="mb-2">Selecione as permissões para esse perfil:</h3>

                <form action="{{ route('admin.role.permissionsSync', ['role' => $role->id]) }}" method="post" class="app_form" autocomplete="off">
                    @csrf
                    @method('PUT')

                    @foreach($permissions as $permission)
                        <div class="label">
                            <label class="label">
                                <input type="checkbox" id="{{ $permission->id }}" name="{{ $permission->id }}" {{ ($permission->can == '1' ? 'checked' : '') }}><span>{{ $permission->name }}</span>
                            </label>
                        </div>
                    @endforeach

                    <div class="text-right mt-2">
                    <button type="submit" class="btn btn-green mt-1">Sincronizar Perfil</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
