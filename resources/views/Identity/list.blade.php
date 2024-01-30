@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Identity List</h1>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="float-right">
                                    <a class="btn btn-block btn-sm btn-success mb-2" href="{{ route('createIdentityForm') }}">Create New Identity</a>
                                </div>

                            </div>
                            <div class="card-body">
                                <table class="table table-bordered mt-3">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>status</th>
                                            <th>approvedDate</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($response->result as $Identity)
                                            <tr>
                                                <td>{{ $Identity->name }}</td>
                                                <td>{{ $Identity->email }}</td>
                                                <td>{{ $Identity->status }}</td>
                                                <td>{{ $Identity->approvedDate }}</td>
                                                <td>
                                                    <form method="POST"
                                                        action="{{ route('deleteIdentity', ['email' => $Identity->email]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link">Delete</button>
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
        </section>
    </div>
@endsection
