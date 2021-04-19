<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;

class CartItemControllerTest extends TestCase
{
    use RefreshDatabase;

    private $fakeUser;

    protected function setup(): void
    {
        parent::setup();
        $this->fakeUser = User::create([
            'name' => 'jiro',
            'email' => 'jiro@test.com',
            'password' => '12345678'
        ]);
        Passport::actingAs($this->fakeUser);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStore()
    {
        $cart = $this->fakeUser->carts()->create();
        $product = Product::create([
            'title' => 'test product',
            'content' => 'new',
            'price' => 10,
            'quantity' => 10
        ]);

        $response = $this->call(
            'POST',
            'cart-items',
            [
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 2
            ]
        );

        $response->assertOk();

        $response = $this->call(
            'POST',
            'cart-items',
            [
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 400
            ]
        );

        $response->assertStatus(400);
    }

    public function testUpdate()
    {
        $cart = $this->fakeUser->carts()->create();
        $product = Product::create([
            'title' => 'test product',
            'content' => 'new',
            'price' => 10,
            'quantity' => 10
        ]);
        $cartItem = $cart->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        $response = $this->call(
            'PUT',
            'cart-items/' . $cartItem->id,
            [
                'quantity' => 1
            ]
        );

        $this->assertEquals('true', $response->getContent());

        $cartItem->refresh();

        $this->assertEquals(1, $cartItem->quantity);
    }

    public function testDestroy()
    {
        $cart = $this->fakeUser->carts()->create();
        $product = Product::create([
            'title' => 'test product',
            'content' => 'new',
            'price' => 10,
            'quantity' => 10
        ]);
        $cartItem = $cart->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        $response = $this->call(
            'DELETE',
            'cart-items/' . $cartItem->id
        );

        $response->assertOk();

        $cartItem = CartItem::find($cartItem->id);

        $this->assertNull($cartItem);
    }
}
