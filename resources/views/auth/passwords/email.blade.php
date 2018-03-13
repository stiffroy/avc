@extends('layouts.dashboard')

@section('content')
<section class="content-header">
    <h1>
        Reset Password
        <small>Only for members</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li class="active"><a href="#">Reset Password</a></li>
    </ol>
</section>
<section class="content container-fluid">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title text-center">Reset Password</h3>
        </div>
        <div class="box-body">
            <div class="col-md-6 col-md-offset-3 col-xs-12">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="form-inline">
                    @csrf
                    <div class="form-group">
                        <label for="email">E-Mail Address</label>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Send Password Reset Link
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
