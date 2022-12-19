@extends('layouts.app')
@section('title', 'Permissions')
@section('content')

        <div class="col-lg-12 p-5">
            <div class="card rounded border-0">
                <div class="card-body p-4">
                    <div class="row dt-table-header">

                        <div class="col-md-2 py-2">
                            <div class="search">
                                <i class="bi bi-search"></i>Search
                                <input class="form-control form-control-sm" type="search"
                                       placeholder="Search..." id="liveSearch" aria-label="search">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="permissionTb"
                               class="table w-100 fw-normal align-middle"
                               aria-describedby="heading">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dashboard/permission.js') }}"></script>
@endsection
