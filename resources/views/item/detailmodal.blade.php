<!-- Modal Component -->
<div class="modal fade" id="modal-{{ $item->id }}" tabindex="-1" aria-labelledby="modal-{{ $item->id }}-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="modal-{{ $item->id }}-label">{{ $item->name }}</h5>

            </div>
            <div class="modal-body">
                <p><strong>画像:</strong></p>
                <img src="{{ asset($item->image) }}" alt="Item Image" class="modal-image modal-image-responsive">
                <p><strong>ID:</strong> {{ $item->id }}</p>
                <p><strong>種別:</strong><br> {{ $item->type }}</p>
                <p><strong>詳細:</strong><br> {{ $item->detail }}</p>
            </div>
        </div>
    </div>
</div>


