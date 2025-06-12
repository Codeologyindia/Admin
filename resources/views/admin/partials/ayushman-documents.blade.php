{{-- Show uploaded documents in a grid, no image preview in popup --}}
<div>
    <h6 class="mb-3" style="color:#232946;">
        <i class="bi bi-paperclip"></i> Uploaded Documents
    </h6>
    <div class="row">
        @forelse($docs as $doc)
            @php
                $ext = strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION));
                $isImage = in_array($ext, ['jpg','jpeg','png','gif','bmp','webp']);
                $icon = $isImage
                    ? '<i class="bi bi-image" style="font-size:2.2em;color:#3b82f6"></i>'
                    : '<i class="bi bi-file-earmark" style="font-size:2.2em;color:#232946"></i>';
            @endphp
            <div class="col-md-2 col-4 mb-4 text-center">
                <div class="border rounded shadow-sm p-2 bg-light h-100 d-flex flex-column align-items-center justify-content-between" style="min-height:120px;">
                    <div>{!! $icon !!}</div>
                    <div class="mt-1 mb-1">
                        <a href="{{ route('admin.ayushman-card-query.documents', ['id' => $doc->id]) }}" target="_blank" style="word-break:break-all;font-size:0.98em;">
                            {{ $doc->name ?: 'Document' }}
                        </a>
                    </div>
                    <div>
                        <span class="badge bg-secondary text-uppercase">{{ strtoupper($ext) }}</span>
                        <span class="d-block text-muted small mt-1">{{ $doc->created_at ? $doc->created_at->format('Y-m-d') : '' }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">No documents uploaded.</div>
        @endforelse
    </div>
</div>
