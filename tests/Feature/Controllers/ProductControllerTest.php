<?php

namespace Tests\Feature;

use App\Http\Services\ShortUrlService;
use App\Http\Services\AuthService;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setup(): void
    {
        parent::setup();
    }

    public function testSharedUrl()
    {
        $product = Product::factory()->create();
        $id = $product->id;

        $this->mock(ShortUrlService::class, function($mock) use($id) {
            $mock->shouldReceive('makeShortUrl')
                ->with("http://127.0.0.1:8000/products/$id")
                ->andReturn('fakeUrl');
        });

        $this->mock(AuthService::class, function($mock) {
            $mock->shouldReceive('fakeReturn');
        });

        $response = $this->call(
            'GET',
            "/products/shared-url/$id"
        );

        $response->assertOk();

        $response = json_decode($response->getContent(), true);

        $this->assertEquals($response['url'], 'fakeUrl');
    }
}
