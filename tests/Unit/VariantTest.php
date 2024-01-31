<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VariantTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateVariant()
    {
        $product = Product::factory()->create();

        $response = $this->post("/api/products/{$product->id}/variants", [
            'name' => 'Test Variant',
            'sku' => 'variant_sku',
            'additional_cost' => 80.17,
            'stock_count' => 26,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('variants', ['name' => 'Test Variant']);
    }

    public function testGetVariant()
    {
        $product = Product::factory()->create();
        $variant = Variant::factory()->create(['product_id' => $product->id]);

        $response = $this->get("/api/products/{$product->id}/variants/{$variant->id}");

        $response->assertStatus(200);
        $response->assertJson(["data" => ['name' => $variant->name]]);
    }

    public function testUpdateVariant()
    {
        $product = Product::factory()->create();
        $variant = Variant::factory()->create(['product_id' => $product->id]);

        $response = $this->put("/api/products/{$product->id}/variants/{$variant->id}", [
            'name' => 'Updated Variant',
            'sku' => 'updated_sku',
            'additional_cost' => 90.99,
            'stock_count' => 30,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('variants', ['name' => 'Updated Variant']);
    }

    public function testDeleteVariant()
    {
        $product = Product::factory()->create();
        $variant = Variant::factory()->create(['product_id' => $product->id]);

        $response = $this->delete("/api/products/{$product->id}/variants/{$variant->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('variants', ['id' => $variant->id]);
    }
}