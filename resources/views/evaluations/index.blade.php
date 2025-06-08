@extends('layouts.auth')
@section('title', 'Evaluation Groups')
@section('content')
<div class="container-fluid">
    <!-- Flash Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    @endif

    <!-- DataTables Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Evaluation Groups List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="menuDataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Asesi Group</th>
                            <th width="25%">Asesi Name</th>
                            <th width="45%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asesiUsers as $key => $user)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $user->group_name }}</td>
                            <td>{{ $user->firstname }}</td>
                            <td>
                                @if($user->has_evaluation)
                                    <button class="btn btn-info btn-sm view-evaluation" data-asesi-id="{{ $user->user_id }}" data-toggle="modal" data-target="#evaluationModal">
                                        <i class="fas fa-eye"></i> View Evaluation
                                    </button>
                                    <a href="{{ route('evaluations.exportPdf', ['asesi_id' => $user->user_id]) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-file-pdf"></i> Export PDF
                                    </a>
                                @else
                                    <a href="{{ route('evaluations.create', ['asesi_id' => $user->user_id]) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Evaluate
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Evaluation Modal -->
    <div class="modal fade" id="evaluationModal" tabindex="-1" role="dialog" aria-labelledby="evaluationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="evaluationModalLabel">Evaluation Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 id="asesi-name"></h6>
                    <p><strong>Month:</strong> <span id="evaluation-month"></span></p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Criteria</th>
                                <th>Weight</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        <tbody id="evaluation-details">
                        </tbody>
                    </table>
                    <p><strong>Total Score:</strong> <span id="total-score"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#menuDataTable').DataTable({
            "dom": '<"top"<"dataTables_length"l><"dataTables_filter"f>>rt',
            "pageLength": 25,
            "language": {
                "search": "Search:",
                "lengthMenu": "Show _MENU_ entry",
                "paginate": {
                    "previous": "Previous",
                    "next": "Next"
                }
            },
        });

        // Handle View Evaluation button click
        $('.view-evaluation').on('click', function() {
            var asesiId = $(this).data('asesi-id');
            
            $.ajax({
                url: '{{ route("evaluations.show", ":asesi_id") }}'.replace(':asesi_id', asesiId),
                method: 'GET',
                success: function(response) {
                    $('#asesi-name').text('Asesi: ' + response.asesi_name);
                    $('#evaluation-month').text(response.month);
                    $('#total-score').text(response.total_score);

                    var detailsHtml = '';
                    response.details.forEach(function(detail) {
                        detailsHtml += `
                            <tr>
                                <td>${detail.penilaian}</td>
                                <td>${detail.bobot}</td>
                                <td>${detail.score}</td>
                            </tr>
                        `;
                    });
                    $('#evaluation-details').html(detailsHtml);
                },
                error: function(xhr) {
                    alert('Error loading evaluation: ' + (xhr.responseJSON.error || 'Unknown error'));
                }
            });
        });
    });
</script>
@endpush
@push('styles')
<style>
    .table-responsive {
        overflow-x: auto;
    }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        display: inline-block;
        margin-bottom: 3px;
    }
    .dataTables_wrapper .dataTables_length {
        float: left;
    }
    .dataTables_wrapper .dataTables_filter {
        float: right;
    }
    .dataTables_wrapper .dataTables_filter input {
        margin-left: 0.5em;
        display: inline-block;
        width: auto;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5em 1em;
        margin-left: 2px;
        border-radius: 4px;
    }
    .card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    .dataTables_wrapper:after {
        content: "";
        display: table;
        clear: both;
    }
</style>
@endpush