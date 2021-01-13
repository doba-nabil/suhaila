<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CartController extends Controller
{
    public function cart()
    {
//        $cartItem = Cart::add($id, $name, $price, $quantity, [
//            'color' => 'white',
//        ]);
        $cartItem = Cart::add(array(
            array(
                'id' => 456,
                'name' => 'Sample Item 1',
                'price' => 67.99,
                'quantity' => 4,
                'attributes' => array()
            ),
            array(
                'id' => 568,
                'name' => 'Sample Item 2',
                'price' => 69.25,
                'quantity' => 4,
                'attributes' => array(
                    'size' => 'L',
                    'color' => 'blue'
                )
            ),
        ));

        return Cart::getContent() ;



    }
}
