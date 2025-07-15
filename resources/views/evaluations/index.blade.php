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

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs" id="evaluationTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="asesi-tab" data-toggle="tab" href="#asesi" role="tab" aria-controls="asesi" aria-selected="true">
                <i class="fas fa-users"></i> Asesi to Evaluate
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="results-tab" data-toggle="tab" href="#results" role="tab" aria-controls="results" aria-selected="false">
                <i class="fas fa-chart-line"></i> Evaluation Results
            </a>
        </li>
    </ul>

    <div class="tab-content" id="evaluationTabsContent">
        <!-- Asesi to Evaluate Tab -->
        <div class="tab-pane fade show active" id="asesi" role="tabpanel" aria-labelledby="asesi-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Asesi List to Evaluate</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="asesiDataTable" width="100%" cellspacing="0">
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
        </div>

        <!-- Evaluation Results Tab -->
        <div class="tab-pane fade" id="results" role="tabpanel" aria-labelledby="results-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Completed Evaluations - {{ now()->format('F Y') }}</h6>
                </div>
                <div class="card-body">
                    @if($evaluationResults->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-bordered" id="resultsDataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="20%">Asesi Name</th>
                                        <th width="15%">Group</th>
                                        <th width="12%">Total Score</th>
                                        <th width="12%">Grade</th>
                                        <th width="12%">Status</th>
                                        <th width="12%">Date</th>
                                        <th width="12%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($evaluationResults as $key => $result)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $result->asesi->firstname }}</td>
                                        <td>
                                            @php
                                                $groupName = $penilaians->where('asesi_id', $result->asesi->group_id)->first();
                                            @endphp
                                            {{ $groupName->asesi->group_name ?? 'N/A' }}
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $result->total_score }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $gradeClass = '';
                                                switch($result->final_grade) {
                                                    case 'A':
                                                        $gradeClass = 'badge-success';
                                                        break;
                                                    case 'B':
                                                        $gradeClass = 'badge-primary';
                                                        break;
                                                    case 'C':
                                                        $gradeClass = 'badge-warning';
                                                        break;
                                                    case 'D':
                                                        $gradeClass = 'badge-danger';
                                                        break;
                                                    default:
                                                        $gradeClass = 'badge-secondary';
                                                }
                                            @endphp
                                            <span class="badge {{ $gradeClass }}">{{ $result->final_grade }}</span>
                                        </td>
                                        <td>
                                            @if($result->status == 'completed')
                                                <span class="badge badge-success">Completed</span>
                                            @elseif($result->status == 'draft')
                                                <span class="badge badge-warning">Draft</span>
                                            @else
                                                <span class="badge badge-secondary">{{ ucfirst($result->status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $result->created_at->format('d M Y') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info view-result-detail" data-evaluation-id="{{ $result->evaluation_id }}" data-toggle="modal" data-target="#resultDetailModal">
                                                <i class="fas fa-eye"></i> Detail
                                            </button>
                                            <a href="{{ route('evaluations.exportPdf', ['asesi_id' => $result->asesi_ternilai_id]) }}" class="btn btn-sm btn-success">
                                                <i class="fas fa-download"></i> PDF
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No evaluations completed yet</h5>
                            <p class="text-muted">Complete some evaluations to see results here.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Evaluation Modal (existing) -->
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

    <!-- Result Detail Modal (new) -->
    <div class="modal fade" id="resultDetailModal" tabindex="-1" role="dialog" aria-labelledby="resultDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resultDetailModalLabel">Evaluation Result Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><strong>Asesi:</strong> <span id="result-asesi-name"></span></h6>
                            <p><strong>Month:</strong> <span id="result-month"></span></p>
                        </div>
                        <div class="col-md-6">
                            <h6><strong>Total Score:</strong> <span id="result-total-score" class="badge badge-info"></span></h6>
                            <p><strong>Grade:</strong> <span id="result-grade" class="badge"></span></p>
                        </div>
                    </div>
                    <hr>
                    <h6>Evaluation Details:</h6>
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Criteria</th>
                                <th>Score</th>
                                <th>Comments</th>
                            </tr>
                        </thead>
                        <tbody id="result-evaluation-details">
                        </tbody>
                    </table>
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
        // Initialize DataTables
        $('#asesiDataTable').DataTable({
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

        $('#resultsDataTable').DataTable({
            "dom": '<"top"<"dataTables_length"l><"dataTables_filter"f>>rt',
            "pageLength": 25,
            "order": [[ 6, "desc" ]], // Sort by date column descending
            "language": {
                "search": "Search:",
                "lengthMenu": "Show _MENU_ entry",
                "paginate": {
                    "previous": "Previous",
                    "next": "Next"
                }
            },
        });

        // Handle View Evaluation button click (existing)
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

        // Handle View Result Detail button click (new)
        $('.view-result-detail').on('click', function() {
            var evaluationId = $(this).data('evaluation-id');
            
            $.ajax({
                url: '{{ route("evaluations.showResult", ":evaluation_id") }}'.replace(':evaluation_id', evaluationId),
                method: 'GET',
                success: function(response) {
                    $('#result-asesi-name').text(response.asesi_name);
                    $('#result-month').text(response.month);
                    $('#result-total-score').text(response.total_score);
                    
                    // Set grade badge color
                    var gradeClass = '';
                    switch(response.final_grade) {
                        case 'A':
                            gradeClass = 'badge-success';
                            break;
                        case 'B':
                            gradeClass = 'badge-primary';
                            break;
                        case 'C':
                            gradeClass = 'badge-warning';
                            break;
                        case 'D':
                            gradeClass = 'badge-danger';
                            break;
                        default:
                            gradeClass = 'badge-secondary';
                    }
                    $('#result-grade').removeClass().addClass('badge ' + gradeClass).text(response.final_grade);

                    var detailsHtml = '';
                    response.details.forEach(function(detail) {
                        detailsHtml += `
                            <tr>
                                <td>${detail.criteria_name}</td>
                                <td><span class="badge badge-info">${detail.score}</span></td>
                                <td>${detail.comments || '-'}</td>
                            </tr>
                        `;
                    });
                    $('#result-evaluation-details').html(detailsHtml);
                },
                error: function(xhr) {
                    alert('Error loading result: ' + (xhr.responseJSON.error || 'Unknown error'));
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
    .nav-tabs .nav-link {
        border-radius: 0.375rem 0.375rem 0 0;
    }
    .nav-tabs .nav-link.active {
        font-weight: 600;
    }
    .tab-content {
        border: 1px solid #dee2e6;
        border-top: none;
        border-radius: 0 0 0.375rem 0.375rem;
        padding: 1rem;
        background-color: #fff;
    }
    .badge {
        font-size: 0.75em;
    }
</style>
@endpush