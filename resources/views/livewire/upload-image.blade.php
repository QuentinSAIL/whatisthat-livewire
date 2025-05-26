<div>
    <p class="mb-4">Analyser une image</p>
    <input type="file" wire:model="image" accept="image/*" class="form-control mb-2">

    @if ($description)
        <div class="alert alert-info mt-2">
            {{ $description }}
        </div>

        <flux:button wire:click="uploadImage" class="btn btn-success mt-2">
            Upload
        </flux:button>
    @elseif ($image)
        <flux:button wire:click="analyzeImage" class="btn btn-primary mt-2">
            Analyze Image
        </flux:button>
    @endif
</div>
