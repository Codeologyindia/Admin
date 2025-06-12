<div>
    <h6 class="fw-bold mb-3 text-primary">
        <i class="bi bi-paperclip"></i> Uploaded Documents
    </h6>
    <div class="row">
        @if($otherDocs->count())
            @foreach($otherDocs as $doc)
                @php
                    $ext = strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION));
                    $icon = 'bi-file-earmark';
                    if (in_array($ext, ['xls', 'xlsx', 'csv'])) $icon = 'bi-file-earmark-excel text-success';
                    elseif (in_array($ext, ['pdf'])) $icon = 'bi-file-earmark-pdf text-danger';
                    elseif (in_array($ext, ['doc', 'docx'])) $icon = 'bi-file-earmark-word text-primary';
                    elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) $icon = 'bi-file-earmark-image text-info';
                @endphp
                <div class="col-12 col-md-2 mb-3">
                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="d-flex flex-column align-items-center text-decoration-none border rounded p-3 bg-light h-100 shadow-sm hover-shadow">
                        <i class="bi {{ $icon }} fs-1 mb-2"></i>
                        <span class="fw-semibold text-truncate" style="max-width:120px;">{{ $doc->name ?: basename($doc->file_path) }}</span>
                        <span class="badge bg-secondary mt-2 text-uppercase">{{ $ext }}</span>
                        <span class="small text-muted mt-1">
                            {{ $doc->created_at ? $doc->created_at->format('Y-m-d') : '' }}
                        </span>
                    </a>
                </div>
            @endforeach
        @else
            <div class="col-12 text-muted">No documents uploaded.</div>
        @endif
    </div>
    <style>
        .hover-shadow:hover {
            box-shadow: 0 4px 16px rgba(34,43,69,0.13);
            background: #f4f8ff;
            transition: box-shadow 0.2s, background 0.2s;
        }
    </style>
</div>
