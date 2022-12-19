@extends('layouts.app')

@section('content')

    <div class="col-lg-12 p-5">
        <div class="card rounded border-0">
            <div class="card-body p-4">
                <div class="row dt-table-header">
                    <div class="col-lg-8 col-md-10 col-sm-12 me-auto d-flex">
                        @can('UserCreate')
                            <a href="{{ route('admin.user.create') }}"
                               class="btn btn-sm light btn-primary me-2 my-auto">
                                <i class="bi bi-plus-square"></i>&nbsp;<span>Create New</span>
                            </a>
                        @endcan

                            <button class="btn btn-sm light btn-success me-2 my-auto" id="activate">
                                <i class="bi bi-trash3"></i>&nbsp;<span>Activate User</span>
                            </button>

                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-12 ms-auto">
                        <div class="search">
                            <i class="bi bi-search"></i>Search
                            <input class="form-control form-control-sm search-control" type="search"
                                   placeholder="Search..." id="liveSearch" aria-label="search">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="userTb" class="table w-100 fw-normal align-middle" aria-describedby="heading">
                        <thead>
                        <tr>
                            <th scope="col" width="30" class="table-check">
                                <input class="form-check-input" type="checkbox" id="checkAll" aria-label="item check">
                            </th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dashboard/user.js') }}"></script>
@endsection
