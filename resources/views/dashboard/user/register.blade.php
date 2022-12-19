@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card rounded border-0">
                <div class="card-body p-4">
                    <form method="post" action="{{ route('admin.user.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}"
                                           required placeholder="Name">
                                    <label for="name" class="form-label">Name</label>
                                </div>

                                @if($errors->has('name'))
                                    <span class="text-danger small fw-bolder">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email') }}"
                                           required autocomplete="off" placeholder="E-mail Address">
                                    <label for="email" class="form-label">E-mail Address</label>
                                </div>
                                @if($errors->has('email'))
                                    <span class="text-danger small fw-bolder">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password" name="password" required autocomplete="off"
                                           placeholder="Password">
                                    <label for="password" class="form-label">Password</label>
                                </div>
                                @if ($errors->has('password'))
                                    <span
                                        class="text-danger small fw-bolder">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <input type="password"
                                           class="form-control @error('password_confirmation') is-invalid @enderror"
                                           id="con_password" name="password_confirmation" required autocomplete="off"
                                           placeholder="Confirm Password">
                                    <label for="con_password" class="form-label">Confirm Password</label>
                                </div>
                                @if ($errors->has('password_confirmation'))
                                    <span
                                        class="text-danger small fw-bolder">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a class="btn btn-secondary float-start"
                                   href="{{ route('admin.user.index') }}">
                                    <i class="bi bi-x-circle"></i>&nbsp;Cancel
                                </a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-primary float-end" type="submit">Save&nbsp;<i
                                        class="bi bi-plus-circle"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
