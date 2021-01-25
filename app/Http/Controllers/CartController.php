<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartRequest;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(AddCartRequest $request)
    {
        $user = $request->user();
        $skuId = $request->sku_id;
        $amount = $request->amount;
        // 查询该商品是否已经加入购物车
        if ($cart = $user->cartItems()->where('product_sku_id', $skuId)->first()) {
            // 直接修改购物车的数量
            $cart->update(['amount' => $cart->amount + $amount]);
        } else {
            // 创建购物车记录
            $cart = new CartItem(['amount' => $amount]);
            $cart->user()->associate($user);
            $cart->productSku()->associate($skuId);
            $cart->save();
        }
        return [];
    }
}
