@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Your Tasks') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="mt-3">
                        <form action="{{ route('tasks.index') }}" method="GET" class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="Search by title"
                                        value="{{ request()->get('search') }}">
                                </div>
                                <div class="col-md-4">
                                    <input type="date" name="created_at" class="form-control"
                                        value="{{ request()->get('created_at') }}">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                                </div>
                            </div>
                        </form>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Required Time</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create
                                                    New</a>
                                            </div>
                                            <div class="col-md-4">
                                                <p>Total Required Time: {{ $totalRequiredTime }}</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->required_time }}</td>
                                    <td>
                                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary btn-sm">
                                            Edit
                                        </a>
                                        <a href="{{ route('tasks.check', $task->id) }}" class="btn btn-primary btn-sm">
                                            Check
                                        </a>
                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this task?');">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection