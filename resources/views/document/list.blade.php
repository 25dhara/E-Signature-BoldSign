@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Document List</h1>
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
                                            <th>Sender</th>
                                            <th>Sent for Sign</th>
                                            <th>Activity Date</th>
                                            <th>Activity By</th>
                                            <th>Title</th>
                                            <th>Expires in</th>
                                            <th>Status</th>
                                            <th style="width: 170px;">Download</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($response->result as $document)
                                            <tr>
                                                <td>{{ $document->documentId }}</td>
                                                <td>{{ $document->senderDetail->name }}</td>
                                                <td>{{ date('d-m-Y H:i:s', $document->createdDate) }}</td>
                                                <td>{{ date('d-m-Y H:i:s', $document->activityDate) }}</td>
                                                <td>{{ $document->activityBy }}</td>
                                                <td>{{ $document->messageTitle }}</td>
                                                <td>
                                                    @php
                                                        $today_date = new DateTime();
                                                        $expiry_date = new DateTime();
                                                        $expiry_date->setTimestamp($document->expiryDate);

                                                        if ($expiry_date > $today_date) {
                                                            $difference = $today_date->diff($expiry_date);
                                                            echo $difference->format('%a days');
                                                        } else {
                                                            echo 'Expired';
                                                        }
                                                    @endphp
                                                </td>

                                                <td>{{ $document->status }}</td>
                                                <td>
                                                    <div class="d-flex flex-column align-items-start">
                                                        <form method="GET" action="{{ url('download-pdf') }}">
                                                            @csrf
                                                            <input type="hidden" name="documentId"
                                                                value="{{ $document->documentId }}">
                                                            <button type="submit" class="btn btn-link">Download
                                                                PDF</button>
                                                        </form>
                                                        <form method="POST" action="{{ url('revokeDocument') }}">
                                                            @csrf
                                                            <input type="hidden" name="documentId"
                                                                value="{{ $document->documentId }}">
                                                            <button type="submit" class="btn btn-link">Revoke
                                                            </button>
                                                        </form>
                                                        @if ($document->status != 'Completed')
                                                            <form method="POST" action="{{ url('sendRemind') }}">
                                                                @csrf
                                                                <input type="hidden" name="documentId"
                                                                    value="{{ $document->documentId }}">
                                                                <button type="submit" class="btn btn-link">Send
                                                                    Reminder</button>
                                                            </form>

                                                            <form method="POST" action="{{ url('extendExpiry') }}">
                                                                @csrf
                                                                <input type="hidden" name="documentId"
                                                                    value="{{ $document->documentId }}">
                                                                <button type="submit" class="btn btn-link">Extend
                                                                    Expiry</button>
                                                            </form>
                                                        @endif

                                                        @if ($document->status == 'Completed')
                                                            <form method="GET" action="{{ url('download-audittrail') }}">
                                                                @csrf
                                                                <input type="hidden" name="documentId"
                                                                    value="{{ $document->documentId }}">
                                                                <button type="submit" class="btn btn-link"
                                                                    style="white-space: nowrap;">Audit-trail</button>
                                                            </form>
                                                        @endif
                                                    </div>
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
