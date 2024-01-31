<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    //Retrival of data correctly
    public function testProductsAreRetrievedCorrectly()
    {
        Product::factory()->count(5)->create(); // Generate 5 products

        $response = $this->getJson('/api/products'); // Use getJson for JSON responses

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'description', 'price']
                ]
            ]);

    }

    //Show retruned data
    public function testProductShowReturnsCorrectData()
    {
        $product = Product::factory()->create();
    
        $response = $this->getJson("/api/products/$product->id");
    
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'price',
                ],
            ])
            ->assertJson(["data" => ['id' => $product->id]]);
    }
    
    public function testProductShowNonexistentReturnsNotFound()
    {
        $response = $this->getJson('/api/products/100');
    
        $response->assertStatus(404);
    }
    

    //Store data
    public function testProductStoreCreatesNewProduct()
    {
        $data = [
            'name' => 'Test Product',
            'description' => 'A test product description',
            'price' => 9.99,
        ];

        $response = $this->postJson('/api/products', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                    'message',               
            ]);

        $this->assertDatabaseHas('products', ['name' => $data['name']]);
    }

    public function testProductStoreValidationErrors()
    {
        $response = $this->postJson('/api/products', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'price']);
    }


    //Update data
    public function testProductUpdateModifiesExistingProduct()
    {
        $product = Product::factory()->create();
    
        $data = [
            'name' => 'Updated Product Name',
            'description' => 'Updated product description',
            'price' => 14.99,
        ];
    
        $response = $this->putJson("/api/products/$product->id", $data);
    
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'price',
                ],
            ]);
    
        $this->assertDatabaseHas('products', ['name' => $data['name']]);
    }
    
    public function testProductUpdateNonexistentReturnsNotFound()
    {
        $response = $this->putJson('/api/products/100', []);
    
        $response->assertStatus(404);
    }

    //Delete data
    public function testProductDestroyRemovesProduct()
    {
        $product = Product::factory()->create();
    
        $response = $this->deleteJson("/api/products/$product->id");
    
        $response->assertStatus(204);
    
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
    
    public function testProductDestroyNonexistentReturnsNotFound()
    {
        $response = $this->deleteJson('/api/products/100');
    
        $response->assertStatus(404);
    }


    // Search Product
    public function testSearchFunctionality()
    {
        $product = Product::factory()->create(['name' => 'Laptop']);
        $productWithMatch = Product::factory()->create(['description' => 'Smartphone']);
        Variant::factory()->create(['product_id' => $product->id, 'name' => '16GB RAM']);

        $response = $this->getJson('/api/products/search/Smartphone');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonFragment(['description' => $productWithMatch->description]) 
            ->assertDontSee('product_id')
            ->assertDontSee('Laptop')
            ->assertDontSee('16GB RAM');
    }


    


}
