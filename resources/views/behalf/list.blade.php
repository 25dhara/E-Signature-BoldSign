@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Behalf List</h1>
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

                                <table class="table table-bordered mt-3">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Document ID</th>
                                            <th>Sender Name</th>
                                            <th>Sender Email</th>
                                            <th>Behalf Of Name</th>
                                            <th>Behalf Of Email</th>
                                            <th>Created Date</th>
                                            <th>Activity Date</th>
                                            <th>Activity By</th>
                                            <th>Message Title</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($response->result as $document)
                                            <tr>
                                                <td>{{ $document->documentId }}</td>
                                                <td>{{ $document->senderDetail->name }}</td>
                                                <td>{{ $document->senderDetail->emailAddress }}</td>
                                                <td>{{ $document->behalfOf->name }}</td>
                                                <td>{{ $document->behalfOf->emailAddress }}</td>
                                                <td>{{ date('Y-m-d H:i:s', $document->createdDate) }}</td>
                                                <td>{{ date('Y-m-d H:i:s', $document->activityDate) }}</td>
                                                <td>{{ $document->activityBy }}</td>
                                                <td>{{ $document->messageTitle }}</td>
                                                <td>{{ $document->status }}</td>
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
