@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card rounded border-0">
                <div class="card-body p-4">
                    <form method="post" action="{{ route('admin.sub.category.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name" value="{{ old('name') }}" required placeholder="name">
                                    <label for="name" class="form-label">Name</label>
                                </div>
                                @if($errors->has('name'))
                                    <span
                                        class="text-danger small font-weight-bolder">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <select id="category_id" name="category_id"
                                            class="select2-input form-select @error('category_id') is-invalid @enderror"
                                            style="width: 100%" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category['id'] }}">
                                                {{ $category['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="category_id" class="form-label">Categories</label>
                                </div>
                                @if($errors->has('category_id'))
                                    <span
                                        class="text-danger small font-weight-bolder">{{ $errors->first('category_id') }}</span>
                                @endif
                            </div>

                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <textarea class="form-control @error('desc') is-invalid @enderror"
                                              id="desc"
                                              name="desc" required placeholder="Description">
                                    </textarea>
                                    <label for="desc" class="form-label">Description</label>
                                </div>
                                @if($errors->has('desc'))
                                    <span
                                        class="text-danger small font-weight-bolder">{{ $errors->first('desc') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a class="btn btn-secondary float-start"
                                   href="{{ route('admin.sub.category.index') }}">
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
