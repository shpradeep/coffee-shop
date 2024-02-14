<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductDetailsTest extends TestCase
{
    /**
     * Test API fetching specific product
     */
    public function test_get_call_api_for_specific_product(): void
    {
        $response = $this->get('product/1');

        $response->assertStatus(200);
    }

    /**
     * Test API fetching all product
     */
    public function test_get_call_api_for_all_product(): void
    {
        $response = $this->get('products');

        $response->assertStatus(200);
    }
}
