<div>
    <input type="file" wire:model="image" accept="image/*" class="form-control mb-2">

    @if ($description)
        <div class="alert alert-info mt-2">
            {{ $description }}
        </div>

        <button wire:click="uploadImage" class="btn btn-success mt-2">
            Upload
        </button>
    @elseif ($image)
        <button wire:click="analyzeImage" class="btn btn-primary mt-2">
            Analyze Image
        </button>
    @endif
</div>
