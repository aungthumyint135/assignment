@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card rounded border-0">
                <div class="card-body p-4">
                    <form method="post" action="{{ route('admin.role.update', $role->uuid) }}">
                        @csrf
                        @method('put')
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                           name="name" value="{{ old('name') ?? $role->name }}" required placeholder="name">
                                    <label for="name" class="form-label">Name</label>
                                </div>
                                @if($errors->has('name'))
                                    <span class="text-danger small font-weight-bolder">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <select type="text" id="permissions" name="permissions[]"
                                            class="select2-input form-select @error('permissions') is-invalid @enderror"
                                            multiple="multiple" style="width: 100%" required>
                                        @foreach($permissions as $permission)
                                            <option value="{{ $permission->name }}"
                                                {{ (in_array($permission->name, old('permissions', [])) || $rolePermissions->contains($permission->name)) ? 'selected' : '' }}>
                                                {{ $permission->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="permissions" class="form-label">Permissions</label>
                                </div>
                                @if($errors->has('permissions'))
                                    <span class="text-danger small font-weight-bolder">{{ $errors->first('permissions') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a class="btn btn-secondary float-start"
                                   href="{{ route('admin.role.index') }}">
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
