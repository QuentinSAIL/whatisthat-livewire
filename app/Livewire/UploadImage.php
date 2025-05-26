<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Aws\Rekognition\RekognitionClient;

class UploadImage extends Component
{
    use WithFileUploads;

    public $image;

    public function uploadImage()
    {
        $this->validate([
            'image' => 'required|image|max:1024', // 1MB Max
        ]);

        // Lire l’image en binaire
        $imageBytes = file_get_contents($this->image->getRealPath());

        // Créer un client Rekognition
        $client = new RekognitionClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        // Détecter les labels
        $result = $client->detectLabels([
            'Image' => [
                'Bytes' => $imageBytes,
            ],
            'MaxLabels' => 10,
            'MinConfidence' => 70,
        ]);

        // Générer la description
        $labels = [];
        foreach ($result['Labels'] as $label) {
            $labels[] = $label['Name'];
        }

        $description = 'Cette image contient : ' . implode(', ', $labels);

        // Sauvegarder l’image avec la description générée
        $userImage = auth()->user()->userImage()->create([
            'description' => $description,
        ]);

        $userImage->addMedia($this->image->getRealPath())
            ->usingName($this->image->getClientOriginalName())
            ->toMediaCollection();

    }

    public function render()
    {
        return view('livewire.upload-image');
    }
}
