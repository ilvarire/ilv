<?php

namespace App\Helpers;

use App\Models\Equipment;
use App\Models\Food;
use App\Models\FoodPrice;
use App\Models\Product;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class CartSession
{
    static public function addCartItemsToSession($cart_items)
    {
        // Store the entire cart in the session
        Session::put('cart_items', $cart_items);
    }

    static public function clearCartItems()
    {
        // Remove cart items from session
        Session::forget('cart_items');
    }

    static public function getCartItemsFromSession()
    {
        $cart_items = Session::get('cart_items', []);
        $validatedCart = [];

        foreach ($cart_items as $item) {
            if (! isset($item['product_id'])) {
                continue; // skip invalid
            }

            // -------------------
            // Product Items
            // -------------------
            if (is_numeric($item['quantity'])) {
                $product = Product::with('images')->find($item['product_id']);
                if ($product && $product->quantity >= $item['quantity']) {
                    $quantity = max(1, (int) $item['quantity']);
                    $validatedCart[] = [
                        'product_id'      => $product->id,
                        'name'         => $product->name,
                        'slug'         => $product->slug,
                        'brief'         => $product->brief,
                        'description'         => $product->description,
                        'images'    => $product->images,
                        'weight'       => $product->weight * $quantity,
                        'quantity'     => $quantity,
                        'stock' => $product->quantity,
                        'unit_price'   => $product->price,
                        'total_amount' => $product->price * $quantity,
                    ];
                }
            }
        }

        return $validatedCart;
    }

    public static function addProductToCart($product_id, $quantity = 1)
    {
        // Get current cart items from session
        $cart_items = self::getCartItemsFromSession();

        // Check if product already exists in cart
        $existing_item_key = collect($cart_items)->search(fn($item) => $item['product_id'] == $product_id);

        // If product exists, update it
        if ($existing_item_key !== false) {
            $cart_items[$existing_item_key]['quantity'] = $quantity;

            // Save updated cart
            self::addCartItemsToSession($cart_items);
            return response()->json([
                'message' => 'Already in cart.',
                'type' => 'info',
                'cart_count' => count($cart_items),
            ], 200);
        }

        $cart_items[] = [
            'product_id'   => $product_id,
            'quantity'     => $quantity
        ];

        // Save updated cart back to session
        self::addCartItemsToSession($cart_items);

        return response()->json([
            'message' => 'Added to cart successfully.',
            'type' => 'success',
            'cart_count' => count($cart_items),
        ], 201);
    }

    static public function removeProductFromCart($product_id)
    {
        $cart_items = self::getCartItemsFromSession();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($cart_items[$key]);
                break;
            } else {
                return response()->json([
                    'message' => 'Item not in cart.',
                    'type' => 'info',
                    'cart_count' => count($cart_items),
                ], 201);
            }
        }
        $cart_items = array_values($cart_items);
        self::addCartItemsToSession($cart_items);

        return response()->json([
            'message' => 'Item removed successfully.',
            'type' => 'success',
            'cart_count' => count($cart_items),
        ], 201);
    }

    static public function incrementProductQuantity($product_id)
    {
        $cart_items = self::getCartItemsFromSession();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $cart_items[$key]['quantity']++;
                $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_price'];
                break;
            }
        }

        // 🟢 Save updated cart back to session
        self::addCartItemsToSession($cart_items);

        return response()->json([
            'message' => 'Product quantity incremented successfully.',
            'status' => 'success'
        ], 201);
    }

    static public function decrementProductQuantity($product_id)
    {
        $cart_items = self::getCartItemsFromSession();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                if ($cart_items[$key]['quantity'] > 1) {
                    $cart_items[$key]['quantity']--;
                    $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_price'];
                }
                break;
            }
        }
        self::addCartItemsToSession($cart_items);

        return response()->json([
            'message' => 'Product quantity decremented successfully.',
            'status' => 'success'
        ], 201);
    }

    public static function isProductInCart($productId)
    {
        $cart_items = self::getCartItemsFromSession();
        $existing_item_key = collect($cart_items)->search(fn($item) => $item['product_id'] == $productId);
        return $existing_item_key !== false;
    }
    public static function updateProductQuantity($product_id, $quantity)
    {
        $cart_items = self::getCartItemsFromSession();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $cart_items[$key]['quantity'] = $quantity;
                break;
            }
        }

        // 🟢 Save updated cart back to session
        self::addCartItemsToSession($cart_items);

        return response()->json([
            'message' => 'Quantity updated successfully.',
            'type' => 'success',
            'cart_count' => count($cart_items),
        ], 201);
    }

    static public function calculateGrandTotal($items = null)
    {
        // If no items are passed in, get from session
        if (is_null($items)) {
            $items = self::getCartItemsFromSession();
        }

        // Safely sum total_amount values
        return array_sum(array_column($items, 'total_amount'));
    }

    static public function addWishItemsToSession($wish_items)
    {
        // Store the entire wish in the session
        Session::put('wish_items', $wish_items);
    }

    static public function clearWishItems()
    {
        // Remove wish items from session
        Session::forget('wish_items');
    }

    static public function getWishItemsFromSession()
    {
        $wish_items = Session::get('wish_items', []);
        $validatedWish = [];

        foreach ($wish_items as $item) {
            if (! isset($item['product_id'])) {
                continue; // skip invalid
            }

            // -------------------
            // Wish Items
            // -------------------

            $product = Product::with('images')->find($item['product_id']);
            if ($product) {
                $validatedWish[] = [
                    'product_id'      => $product->id,
                    'name'         => $product->name,
                    'slug'         => $product->slug,
                    'brief'         => $product->brief,
                    'description'         => $product->description,
                    'images'    => $product->images,
                    'weight'       => $product->weight,
                    'unit_price'   => $product->price
                ];
            }
        }

        return $validatedWish;
    }

    public static function addProductToWishlist($product_id)
    {
        // Get current wish items from session
        $wish_items = self::getWishItemsFromSession();

        // Check if product already exists in wish
        $existing_item_key = collect($wish_items)->search(fn($item) => $item['product_id'] == $product_id);

        // If product exists, update it
        if ($existing_item_key !== false) {
            self::removeProductFromWish($product_id);
            return response()->json([
                'message' => 'Item removed from wishlist.',
                'type' => 'info',
                'wish_count' => count($wish_items),
            ], 200);
        }

        // Otherwise, add new product to wish

        $wish_items[] = [
            'product_id'   => $product_id,
        ];

        // Save updated wish back to session
        self::addWishItemsToSession($wish_items);

        return response()->json([
            'message' => 'Added to wishlist successfully.',
            'type' => 'success',
            'wish_count' => count($wish_items),
        ], 201);
    }

    static public function removeProductFromWish($product_id)
    {
        $wish_items = self::getWishItemsFromSession();

        foreach ($wish_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($wish_items[$key]);
                break;
            } else {
                return response()->json([
                    'message' => 'Item not in wish.',
                    'type' => 'info',
                    'wish_count' => count($wish_items),
                ], 201);
            }
        }
        $wish_items = array_values($wish_items);
        self::addWishItemsToSession($wish_items);

        return response()->json([
            'message' => 'Item removed successfully.',
            'type' => 'success',
            'wish_count' => count($wish_items),
        ], 201);
    }

    public static function isProductInWishlist($productId)
    {
        $wish_items = self::getWishItemsFromSession();
        $existing_item_key = collect($wish_items)->search(fn($item) => $item['product_id'] == $productId);
        return $existing_item_key !== false;
    }
}
