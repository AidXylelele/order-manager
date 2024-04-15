@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Task Details') }}</div>

                <div class="card-body">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">{{ __('Title') }}</label>
                        <p>{{ $task->title }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Required Time (hours:minutes)') }}</label>
                        <p>{{ $task->required_time }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Description') }}</label>
                        <p>{{ $task->description }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Deadline Date') }}</label>
                        <p>{{ $task->deadline_date }}</p>
                    </div>

                    @if ($file)
                    <div class="mb-3">
                        <label class="form-label">{{ __('Attached Document') }}</label>
                        <p><a href="{{ asset($file->path) }}" target="_blank" class="btn btn-primary">Link here</a></p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection