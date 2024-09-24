<?php

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Storage;


use function Livewire\Volt\{state, title, usesFileUploads, rules, uses, with};
use Mary\Traits\Toast;


usesFileUploads();
uses([Toast::class]);


title('Products');
state([
    'productModal' => false,
    'categoryModal' => false,
    'editMode' => false,
    'search' => '',
    'name' => '',
    'file' => '',
    'comment' => '',
    'imagePath' => '',
    'productImagePath' => '',
    'errorMessage' => '',
    'price' => '',
    'content' => '',
    'selectedCategory' => '',
    'product_name' => ''
]);

with(fn() => ['category' => ProductCategory::all()]);

$showProductModal = function () {
    $this->productModal = true;
    $this->editMode = false;
};

$showCategoryModal = function () {
    $this->categoryModal = true;
    $this->editMode = false;
};

// rules(['product_name' => 'required|min:3', 'price' => 'required', 'selectedCategory' => 'required']);
$saveProduct = function () {
    try {
        // Log the selected category to see if it's empty
        logger('Selected Category:', [$this->selectedCategory]);
        // Apply validation rules specific to saving a product
        $this->validate([
            'product_name' => 'required|min:3',
            'price' => 'required',
            'selectedCategory' => 'required',
            'file' => 'image|max:1024', // Apply file validation for product only
        ]);

        if ($this->file) {
            // Store the uploaded photo
            // $imagePath =  $this->file->store('images');
            $path = $this->file->store(
                'products',
                'public'
            );
            $this->productImagePath = Storage::url($path);
            Product::create([
                'name' => $this->product_name,
                'product_category_id' => $this->selectedCategory,
                'description' => $this->content,
                'selling_price' => $this->price,
                'image_path' => $this->productImagePath
            ]);
        }
        // Reset fields
        $this->reset(['product_name', 'price', 'file', 'content', 'selectedCategory']);
        $this->productModal = false;
    } catch (Exception $e) {
        // throw $e;
        $this->errorMessage = $e->getMessage();
        // $this->errorMessage = 'The photo must be an image file of type JPEG, PNG, BMP, or GIF.';
    }
};

//rules(['name' => 'required|min:3', 'file' => 'image|max:1024']);
$saveCategory = function () {


    try {
        // Apply validation rules specific to saving a category
        $this->validate([
            'name' => 'required|min:3',
            'file' => 'image|max:1024', // Apply file validation for category only
        ]);
        if ($this->file) {
            // Store the uploaded photo
            // $imagePath =  $this->file->store('images');
            $path = $this->file->store(
                'images',
                'public'
            );
            $this->imagePath = Storage::url($path);

            ProductCategory::create([
                'name' => $this->name,
                'image_path' => $this->imagePath
            ]);

            // $this->reset(['name', 'photo']);
        }
        // Reset fields
        $this->reset(['name', 'file']);
        $this->categoryModal = false;

        // Trigger a toast notification

        $this->success('Save Successfully');
    } catch (Exception $e) {
        $this->errorMessage = $e->getMessage();
        // $this->errorMessage = 'The photo must be an image file of type JPEG, PNG, BMP, or GIF.';
    }
};

$delete = function ($id) {
    ProductCategory::find($id)->delete();
    $this->categoryModal = false;
    $this->warning('Deleted Successfully');
};

$edit = function ($id) {
    $list = ProductCategory::find($id);
    $this->name = $list->name;
};

// $selectedCategory = function () {
//     dd('sdfsdf');
//     //$list = ProductCategory::find($id);
//     $this->categoryValue = $this->category->name;
// }

?>

<div>
    <x-mary-header title="Products" subtitle="Lastest products">
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-bolt" wire:model.live="search" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-tag" class="btn-primary" label="Add Category" @click="$wire.showCategoryModal()" />
            <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.showProductModal()" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-modal wire:model="productModal" title="Add Product" class="backdrop-blur" box-class="bg-red-50">
        <template x-if="$wire.productModal">
            <x-mary-form wire:submit.prevent="saveProduct">
                @if ($errorMessage)
                <span class=" text-red-500">{{ $errorMessage }}</span>
                @endif
                <x-mary-input label="Product Name" wire:model="product_name" />
                <x-mary-input label="Price" wire:model="price" />
                <x-mary-file label='Image' wire:model="file" hint="Only Image" accept="image/png, image/jpeg , image/gif" />
                <x-mary-select label="Category" icon="o-tag" :options="$category" wire:model="selectedCategory" />

                <x-mary-markdown wire:model="content" label="Content" />

                <x-slot:actions>
                    <x-mary-button label="Cancel" />
                    <x-mary-button label="Save" class="btn-primary" type="submit" spinner="save" />
                </x-slot:actions>
                </x-form>
        </template>
    </x-mary-modal>


    <x-mary-modal wire:model="categoryModal" title="Add Category" class="backdrop-blur" box-class="bg-red-50 max-w-4xl">
        <div class="grid grid-cols-2 gap-4">
            <div>
                @foreach ($category as $key => $cat)
                <x-mary-list-item :item="$cat" wire:click="edit( {{ $cat->id }} )">

                    <x-slot:actions>
                        <x-mary-button icon="o-trash" class="text-red-500" wire:click="delete( {{ $cat->id }} )" spinner />
                    </x-slot:actions>
                </x-mary-list-item>
                @endforeach
            </div>

            <div>
                <template x-if="$wire.categoryModal">
                    <x-mary-form wire:submit.prevent="saveCategory">
                        @if ($errorMessage)
                        <span class="text-red-500">{{ $errorMessage }}</span>
                        @endif

                        <x-mary-input label="Name" class="" wire:model="name" />
                        <x-mary-file label='Image' wire:model="file" hint="Only Image" accept="image/png, image/jpeg , image/gif" />
                        <x-mary-input label="Coment" class="" wire:model="comment" />
                        <x-slot:actions>
                            <x-mary-button label="Cancel" />
                            <x-mary-button label="Save" class="btn-primary" type="submit" spinner="save" onclick="event.stopPropagation();" />
                        </x-slot:actions>
                    </x-mary-form>
                </template>

            </div>
        </div>
    </x-mary-modal>

</div>