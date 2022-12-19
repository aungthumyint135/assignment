@extends('layouts.app')
@section('content')

    <div class="bg-light d-flex justify-content-center">
        <div class="col-10 py-5">
            <div class="card">
                <div class="card-header">
                    <h1>Task Assigment Project</h1>
                </div>
                <div class="card-body">
                    <p>
                        What is Lorem Ipsum?
                    </p>

                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                        but also the leap into electronic typesetting, remaining essentially unchanged. It was
                        popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
                        and more recently with desktop publishing software like Aldus PageMaker including versions of
                        Lorem Ipsum.
                    </p>
                </div>
                <div class="card-footer text-center">
                    <a class="btn btn-outline-primary px-5" href="{{ route('login') }}">
                        Login For Admin
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection
