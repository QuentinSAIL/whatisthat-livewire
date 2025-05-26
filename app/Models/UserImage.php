<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Carbon\Carbon;

class UserImage extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'description',
    ];

    public function getMediaDisplay()
    {
        $medias = $this->getMedia()->map(function ($media) {
            return [
                'id' => $media->id,
                'url' => $media->getTemporaryUrl(Carbon::now()->addMinutes(5)),
                'name' => $this->description,
            ];
        });

        return $medias->first();
    }
}
