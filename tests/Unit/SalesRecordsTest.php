<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SalesRecordsTest extends TestCase
{
    /**
     * Test API giving sales records
     */
    public function test_get_call_api()
    {
        $response = $this->get('api/sales_records');

        $response->assertStatus(200);
    }

    /**
     * Test API giving sales records for specific Product
     */
    public function test_get_sales_for_specific_product(): void
    {
        $response = $this->get('api/sales_records/1');

        $response->assertStatus(200);
    }

    /**
     * Test API creating sales records
     */
    public function test_post_call_api()
    {
        $response = $this->post(route('sales_records.store'), [
            'quantity'    => 2,
            'product_id'  => 1,
            'unit_cost'   => 20.50,
            'record_sale' => 64.67
        ]);

        $response->assertStatus(200);
    }
}
