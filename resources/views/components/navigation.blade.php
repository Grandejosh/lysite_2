@php
    $path = explode('/', request()->path());
    $path[1] = (array_key_exists(1, $path)> 0)?$path[1]:'';
    $path[2] = (array_key_exists(2, $path)> 0)?$path[2]:'';
    $path[3] = (array_key_exists(3, $path)> 0)?$path[3]:'';
    $path[4] = (array_key_exists(4, $path)> 0)?$path[4]:'';
@endphp
<div class="navbar navbar-expand-sm navbar-mini navbar-dark fixed-bottom bg-dark d-none d-md-flex p-0" id="demo-navbar">
    <div class="container-fluid">
        <!-- Main Navigation -->
        <ul class="nav navbar-nav flex-nowrap">
            <li class="nav-item dropup {{ $path[0] == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
            </li>
            @can('configuraciones')
                <li class="nav-item dropup {{ $path[0] == 'setting' ? 'active' : '' }}">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Configuración</a>
                    <div class="dropdown-menu">
                        @can('configuraciones_modulos')
                        <a class="dropdown-item {{ $path[0] == 'setting' && $path[1] == 'modules' ? 'active' : '' }}" href="{{ route('setting_modules') }}">Modulos</a>
                        @endcan
                        @can('configuraciones_roles')
                        <a class="dropdown-item {{ $path[0] == 'setting' && $path[1] == 'roles' ? 'active' : '' }}" href="{{ route('setting_roles') }}">Roles</a>
                        @endcan
                        @can('configuraciones_usuarios')
                        <a class="dropdown-item {{ $path[0] == 'setting' && $path[1] == 'users' ? 'active' : '' }}" href="{{ route('setting_users') }}">Usuarios</a>
                        @endcan
                    </div>
                </li>
            @endcan
            @can('academico')
            <li class="nav-item dropup {{ $path[0] == 'academic' ? 'active' : '' }}">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Académico</a>
                <div class="dropdown-menu">
                    @can('academico_tipo_contenido')
                    <a class="dropdown-item {{ $path[0] == 'academic' && $path[1] == 'content_types' ? 'active' : '' }}" href="{{ route('academic_content_types') }}">{{ __('labels.Content Types') }}</a>
                    @endcan
                    @can('academico_cursos')
                    <a class="dropdown-item {{ $path[0] == 'academic' && $path[1] == 'courses' ? 'active' : '' }}" href="{{ route('academic_courses') }}">Cursos</a>
                    @endcan
                    @can('academico_instructors')
                    <a class="dropdown-item {{ $path[0] == 'academic' && $path[1] == 'instructors' ? 'active' : '' }}" href="{{ route('academic_instructors_list') }}">Instructor</a>
                    @endcan
                    @can('academico_alumnos')
                    <a class="dropdown-item {{ $path[0] == 'academic' && $path[1] == 'students' ? 'active' : '' }}" href="{{ route('academic_students') }}">Alumnos</a>
                    @endcan
                    @can('academico_cursos_instructor')
                    <a class="dropdown-item {{ $path[0] == 'academic' && $path[1] == 'instructor' && $path[2] == 'courses' ? 'active' : '' }}" href="{{ route('academic_dash_instructor_courses_list') }}">Cursos Instructor</a>
                    @endcan
                </div>
            </li>
            @endcan
        </ul>
        <!-- // END Main Navigation -->
    </div>
</div>