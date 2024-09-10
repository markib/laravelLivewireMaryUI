<?php

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Mary\Traits\Toast;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can_render_the_product_component', function () {
    $component = Livewire::test('product.product-index'); // Update this to the correct path for your component
    $component->assertSee('Products');
    $component->assertSee('Add Category');
    $component->assertSee('Add Product');
});

it('can_show_product_modal', function () {
    $component = Livewire::test('product.product-index');
    $component->call('showProductModal');
    $component->assertSet('productModal', true);
});

it('can_save_a_product', function () {
    // Create a fake category for testing
    $category = ProductCategory::factory()->create();

    // Create a fake image file
    Storage::fake('public');
    $image = UploadedFile::fake()->image('product.jpg');

    // Test the product saving functionality
    $component = Livewire::test('product.product-index')
        ->set('product_name', 'Test Product')
        ->set('price', '100')
        ->set('selectedCategory', $category->id)
        // ->set('content', 'This is test description')
        ->set('file', $image)
        ->call('saveProduct');

    $component->assertHasNoErrors();

    // Check if the product was created in the database
    $this->assertDatabaseHas('products', [
        'name' => 'Test Product',
        'product_category_id' => $category->id,
        // 'description' => 'This is test description',
        'selling_price' => '100',
        'image_path' => Storage::url('products/' . $image->hashName())
    ]);

    // Check if the image was stored
    Storage::disk('public')->assertExists('products/' . $image->hashName());
});

it('can_save_a_category', function () {
    // Create a fake image file
    Storage::fake('public');
    $image = UploadedFile::fake()->image('category.jpg');

    // Test the category saving functionality
    $component = Livewire::test('product.product-index')
        ->set('name', 'Test Category')
        ->set('file', $image)
        ->call('saveCategory');

    $component->assertHasNoErrors();

    // Check if the category was created in the database
    $this->assertDatabaseHas('product_categories', [
        'name' => 'Test Category',
    ]);

    // Check if the image was stored
    Storage::disk('public')->assertExists('images/' . $image->hashName());
});

it('can_delete_a_category', function () {
    // Create a category to delete
    $category = ProductCategory::factory()->create();

    // Test the delete functionality
    $component = Livewire::test('product.product-index')
        ->call('delete', $category->id);

    // Check if the category was deleted from the database
    $this->assertDatabaseMissing('product_categories', [
        'id' => $category->id,
    ]);
});

it('sets_the_name_property_when_category_edit_is_called', function () {
    // Create a category to use for the test
    $category = ProductCategory::factory()->create(['name' => 'Test Category']);

    // Render the component
    $component = Livewire::test('product.product-index') // replace with actual component class or name
    ->call('edit', $category->id);

    // Assert that the name property is set correctly
    $component->assertSet('name', 'Test Category');
});