<div class="grid gap-4 md:grid-cols-3 mt-6">
    @foreach ($images as $image)
        @php
            $media = $image->getMediaDisplay();
        @endphp
        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <img src="{{ $media['url'] }}" alt="{{ $media['name'] }}" class="h-full w-full object-cover" />
            <div class="absolute bottom-0 w-full bg-black/60 text-white p-2 text-sm">
                {{ $media['name'] }}
            </div>
        </div>
    @endforeach
</div>
