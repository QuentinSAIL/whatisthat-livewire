<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Aws\Rekognition\RekognitionClient;

class UploadImage extends Component
{
    use WithFileUploads;

    public $image;
    public $description = null;

    public function analyzeImage()
    {
        $this->validate([
            'image' => 'required|image',
        ]);

        $imageBytes = file_get_contents($this->image->getRealPath());

        $client = new RekognitionClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $result = $client->detectLabels([
            'Image' => [
                'Bytes' => $imageBytes,
            ],
            'MaxLabels' => 10,
            'MinConfidence' => 70,
        ]);

        $labels = [];
        foreach ($result['Labels'] as $label) {
            $labels[] = $label['Name'];
        }

        $this->description = 'Cette image contient : ' . implode(', ', $labels);
    }

    public function uploadImage()
    {
        if (!$this->description) {
            // Prevent uploading without analyzing
            session()->flash('error', 'Veuillez d’abord analyser l’image.');
            return;
        }

        $userImage = auth()->user()->userImage()->create([
            'description' => $this->description,
        ]);

        $userImage->addMedia($this->image->getRealPath())
            ->usingName($this->image->getClientOriginalName())
            ->toMediaCollection();

        $this->reset(['image', 'description']);
        $this->dispatch('images.refresh');

    }

    public function render()
    {
        return view('livewire.upload-image');
    }
}
