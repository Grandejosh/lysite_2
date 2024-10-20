<div>
    @php
        $path = explode('/', request()->path());
        $path[1] = (array_key_exists(1, $path)> 0)?$path[1]:'';
        $path[2] = (array_key_exists(2, $path)> 0)?$path[2]:'';
    @endphp
    <nav class="nav page-nav__menu">
        <a style="background: none;" class="nav-link {{ $path[1] == 'edit_account' ? 'active' : '' }}" href="{{ route('user_edit_account') }}">Información básica</a>
        <a style="background: none;" class="nav-link {{ $path[1] == 'edit_profile' ? 'active' : '' }}" href="{{ route('user_edit_account_profile') }}">Privacidad del perfil</a>
        <a style="background: none;" class="nav-link {{ $path[1] == 'edit_password' ? 'active' : '' }}" href="{{ route('user_edit_account_password') }}">{{ __('labels.change_password') }}</a>
        <a style="background: none;" class="nav-link {{ $path[1] == 'edit_avatar' ? 'active' : '' }}" href="{{ route('user_edit_account_avatar') }}">Cambiar avatar</a>
    </nav>
</div>
