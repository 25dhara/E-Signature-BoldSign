@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Send Document</h1>
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
                            <div class="card-body">
                                <form method="post" action="{{ url('/sendDocument') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="email" name="email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="OnBehalfOf" class="form-label">OnBehalfOf</label>
                                        <input type="text" class="form-control" id="OnBehalfOf" name="OnBehalfOf">
                                    </div>
                                    <div class="form-group">
                                        <label>CC</label>
                                        <input type="email" class="form-control" id="cc" multiple name="cc">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Send Document</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

{{-- <!-- template.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Send Mail</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title text-center">Send Document for eSign</h1>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="text" class="form-control" id="email" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="OnBehalfOf" class="form-label">OnBehalfOf:</label>
                                <input type="text" class="form-control" id="OnBehalfOf" name="OnBehalfOf">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Send Mail</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional - for Bootstrap components that require JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> --}}
