<?php

use App\Models\ProductCategory;

use function Livewire\Volt\{state, title, usesFileUploads, rules};

usesFileUploads();

title('Products');
state([
    'postModal' => false, 'categoryModal' => false, 'editMode' => false,
    'search' => '', 'name' => '', 'photo' => '','comment'=>''
]);



$showModal = function () {
    $this->postModal = true;
    $this->editMode = false;
};

$showCategoryModal = function () {
    $this->categoryModal = true;
    $this->editMode = false;
};


rules(['name' => 'required|min:3', 'photo' => 'image|max:1024']);
$saveCategory = function () {

   
    try {
        
        // Validate the photo input
        $this->validate();
       
        if ($this->photo) {
            // Store the uploaded photo
            $imagePath =  $this->photo->store('images');

            ProductCategory::create([
                'name' => $this->name,
                'image_path' => $imagePath
            ]);
            // Reset the photo and error message
            $this->photo = null;
            // $this->errorMessage = null;
        }
    } catch (Exception $e) {
        // throw $e;
        // $this->errorMessage = 'The photo must be an image file of type JPEG, PNG, BMP, or GIF.';
    }
}

?>

<div>
    <x-mary-header title="Products" subtitle="Lastest products">
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-bolt" wire:model.live="search" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-tag" class="btn-primary" label="Add Category" @click="$wire.showCategoryModal()" />
            <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.showModal()" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-modal wire:model="postModal" class="backdrop-blur">
        <x-mary-form wire:submit="save">
            <x-mary-input label="Title" wire:model="form.title" />
            <x-mary-input label="Slug" wire:model="form.slug" />
            {{-- <x-mary-textarea label="Content" wire:model="form.content" placeholder="Your content ..." hint="Max 1000 chars" rows="5" inline /> --}}
            <template x-if="$wire.postModal">
                <x-mary-markdown wire:model="form.content" label="Content" />
            </template>
            <x-slot:actions>
                <x-mary-button label="Cancel" />
                <x-mary-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
            </x-form>
    </x-mary-modal>

    <x-mary-modal wire:model="categoryModal" title="Add Category" class="backdrop-blur" box-class="bg-red-50 w-90">
        <x-mary-form wire:submit="saveCategory">
            <x-mary-input label="Name" class="" wire:model="name" />
            <x-mary-file label='Image' wire:model="photo" accept="image/png" crop-after-change>
                <img src="{{ '/BM.png' }}" class="h-20 rounded-lg" />
            </x-mary-file>
            <x-mary-input label="Coment" class="" wire:model="comment" />
            <x-slot:actions>
                <x-mary-button label="Cancel" />
                <x-mary-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
            </x-form>
    </x-mary-modal>

</div>