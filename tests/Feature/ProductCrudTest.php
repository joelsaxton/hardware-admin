<?php

namespace Tests\Feature;

use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use DatabaseMigrations;

    protected User $user;
    protected Category $category;
    protected Brand $brand;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->category = Category::create(['category' => 'Test Category']);
        $this->brand = Brand::create(['brand' => 'Test Brand']);
    }

    public function test_can_list_products(): void
    {
        Product::create([
            'title' => 'Test Product',
            'description' => 'Test Description',
            'category_id' => $this->category->id,
            'brand_id' => $this->brand->id,
            'price' => 1999,
            'stock' => 10,
            'sku' => 'SKU-00001',
            'weight' => 1.5,
        ]);

        $this->actingAs($this->user);

        Livewire::test(ListProducts::class)
            ->assertCanSeeTableRecords(Product::all());
    }

    public function test_can_create_product(): void
    {
        $this->actingAs($this->user);

        Livewire::test(CreateProduct::class)
            ->fillForm([
                'title' => 'New Product',
                'description' => 'New Description',
                'category_id' => $this->category->id,
                'brand_id' => $this->brand->id,
                'price' => '29.99',
                'stock' => 50,
                'sku' => 'SKU-00002',
                'weight' => 2.5,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('products', [
            'title' => 'New Product',
            'sku' => 'SKU-00002',
            'price' => 2999,
        ]);
    }

    public function test_can_update_product(): void
    {
        $product = Product::create([
            'title' => 'Original Title',
            'description' => 'Original Description',
            'category_id' => $this->category->id,
            'brand_id' => $this->brand->id,
            'price' => 1999,
            'stock' => 10,
            'sku' => 'SKU-00003',
            'weight' => 1.5,
        ]);

        $this->actingAs($this->user);

        Livewire::test(EditProduct::class, ['record' => $product->getRouteKey()])
            ->fillForm([
                'title' => 'Updated Title',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_can_delete_product(): void
    {
        $product = Product::create([
            'title' => 'To Delete',
            'description' => 'Will be deleted',
            'category_id' => $this->category->id,
            'brand_id' => $this->brand->id,
            'price' => 1999,
            'stock' => 10,
            'sku' => 'SKU-00004',
            'weight' => 1.5,
        ]);

        $this->actingAs($this->user);

        Livewire::test(EditProduct::class, ['record' => $product->getRouteKey()])
            ->callAction(DeleteAction::class);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}