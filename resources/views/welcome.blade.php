@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Welcome') }}</div>
                <div class="card-body">
                    <h2>Welcome to our application!</h2>
                    <p>Get started by uploading images to the gallery or exploring the existing collection.</p>

                    @auth
                    <script>
                    window.location = "{{ route('tasks.index') }}";
                    </script>
                    @else
                    <div class="mt-3">
                        <a href="{{ route('login') }}" class="btn btn-primary">{{ __('Login') }}</a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-secondary">{{ __('Register') }}</a>
                        @endif
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection