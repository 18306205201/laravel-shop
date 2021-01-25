@extends('layouts.app')
@section('title', '购物车')

@section('content')
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card">
                <div class="card-header">我的购物车</div>
                <div class="card-body">
                    <table>
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>商品信息</th>
                            <th>单价</th>
                            <th>数量</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody class="products-list">
                            @foreach($cartItems as $cartItem)
                                <tr data-id="{{ $cartItem->productSku->id }}">
                                    <td>
                                        <input type="checkbox" name="select" value="{{ $cartItem->productSku->id }}" {{
                                        $cartItem->productSku->product->on_sale ? 'checked' : 'disabled' }}>
                                    </td>
                                    <td class="product-info">
                                        <div class="preview">
                                            <a href="{{ route('products.show', ['product' => $cartItem->productSku->product->id]) }}" target="_blank">
                                                <img src="{{ $cartItem->productSku->product->image_url }}" alt="">
                                            </a>
                                        </div>
                                        <div @if(!$cartItem->productSku->product->on_sale) class="not_on_sale" @endif>
                                            <span class="product-title">
                                                <a href="{{ route('products.show', ['product' => $cartItem->productSku->product->id]) }}"
                                                   target="_blank">{{ $cartItem->productSku->product->title }}</a>
                                            </span>
                                            <span class="sku_title">{{ $cartItem->productSku->title }}</span>
                                        </div>
                                        @if(!$cartItem->productSku->product->on_sale)
                                            <span class="warning">该商品已下架</span>
                                        @endif
                                    </td>
                                    <td><span class="price">￥{{ $cartItem->productSku->price }}</span></td>
                                    <td><input type="text" class="form-control form-control-sm" value="{{ $cartItem->amount }}"
                                               @if(!$cartItem->productSku->on_sale) disabled @endif name="amount"
                                            ></td>
                                    <td><button class="btn btn-sm btn-danger btn-remove">移除</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
