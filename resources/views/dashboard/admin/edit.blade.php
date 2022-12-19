@extends('layouts.app')
@section('content')
    <div class="col-lg-12">
        <div class="card rounded border-0">
            <div class="card-body p-4">
                <form method="post" action="{{ route('admin.admin.update', $admin->uuid) }}">
                    @csrf
                    @method('put')
                    <div class="row mb-3">
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') ?? $admin->name }}"
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
                                       id="email" name="email" value="{{ old('email') ?? $admin->email }}"
                                       required autocomplete="off" placeholder="E-mail Address">
                                <label for="email" class="form-label">E-mail Address</label>
                            </div>
                            @if($errors->has('email'))
                                <span class="text-danger small fw-bolder">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <select id="role" name="role_id" required
                                        class="form-control form-select @error('role_id') is-invalid @enderror">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->uuid }}"
                                                @if ($role->uuid === old('role_id') || $admin->role_id === $role->id) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <label for="role" class="form-label">Role</label>
                            </div>
                            @if($errors->has('role'))
                                <span class="text-danger small fw-bolder">{{ $errors->first('role') }}</span>
                            @endif
                        </div>

                        @can('ChangePassword')
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="changePwd"
                                           name="change_pwd">
                                    <label class="form-check-label" for="changePwd">Change Password</label>
                                </div>
                            </div>

                            <div class="mb-3" id="pwdDiv">
                                <div class="form-floating">
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password" name="password" autocomplete="off" placeholder="Password">
                                    <label for="password" class="form-label">Password</label>
                                </div>
                                @if ($errors->has('password'))
                                    <span
                                        class="text-danger small fw-bolder">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        @endcan
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <a class="btn btn-secondary float-start"
                               href="{{ route('admin.admin.index') }}">
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
@endsection

@section('scripts')
    <script>
        $(function () {
            $('#pwdDiv').hide();

            dynamicPwdDiv();

            $('#changePwd').change(function () {
                dynamicPwdDiv();
            });
        })

        function dynamicPwdDiv() {
            if ($('#changePwd').is(':checked')) {
                $('#pwdDiv').show();
            } else {
                $('#pwdDiv').hide();
            }
        }
    </script>
@endsection
