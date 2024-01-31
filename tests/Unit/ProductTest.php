<?php

namespace Tests\Unit;


use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateProduct()
    {
        $response = $this->post('/api/products', [
            'name' => 'Test Product',
            'description' => 'Product description',
            'price' => 99.99,
        ]);

        $response->assertStatus(201); // Assuming you return 201 Created on successful creation
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    public function testGetProduct()
    {
        $product = Product::factory()->create();

        $response = $this->get("/api/products/{$product->id}");

        $response->assertStatus(200);
        $response->assertJson(["data"=>['name' => $product->name]]);
    }

    public function testUpdateProduct()
    {
        $product = Product::factory()->create();

        $response = $this->put("/api/products/{$product->id}", [
            'name' => 'Updated Product',
            'description' => 'Updated description',
            'price' => 129.99,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', ['name' => 'Updated Product']);
    }

    public function testDeleteProduct()
    {
        $product = Product::factory()->create();

        $response = $this->delete("/api/products/{$product->id}");

        $response->assertStatus(204); // Assuming you return 204 No Content on successful deletion
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}