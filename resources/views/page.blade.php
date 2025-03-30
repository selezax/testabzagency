@extends('layout')

@section('in_head')
    @vite('resources/sass/app.scss')
@endsection

@section('bodycontent')
    <div class="p-0 m-0 d-flex w-100 h-100 flex-column" id="app">

        <header>
            <div class="navbar navbar-dark bg-dark shadow-sm">
                <div class="container">
                    <a href="#" class="navbar-brand d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2" viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                        <strong>Abz Agency - Test task</strong>
                    </a>
                </div>
            </div>
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="w-100 mt-auto bg-dark text-white py-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        (C) Copyright - {{ \Carbon\Carbon::now()->year }}
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection

@section('end_body')
    @vite('resources/js/app.js')
@endsection
