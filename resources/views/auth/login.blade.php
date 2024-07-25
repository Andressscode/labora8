@extends('layouts.app')	
@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h1>Login</h1>
                </div>
                <div class="card-body">
                    <form action="/login" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value ="{{ old('email') }}">
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password">
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-3">Login</button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-block mt-3">Regresar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
