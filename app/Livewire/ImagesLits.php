<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class ImagesLits extends Component
{
    public $images;

    public function mount()
    {
        $this->refreshImages();
    }

    #[On('images.refresh')]
    public function refreshImages()
    {
        $this->images = auth()->user()->userImage()->get();
    }

    public function render()
    {
        return view('livewire.images-lits');
    }
}
