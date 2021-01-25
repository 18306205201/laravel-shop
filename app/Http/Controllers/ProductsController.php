<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $builder = Product::query()->where('on_sale', true);
        // 判断是否有 search 参数
        if ($search = $request->input('search', '')) {
            $like = '%' . $search . '%';
            // 模糊搜索商品标题，商品描述，SKU标题，SKU 描述
            $builder->where(function ($query) use ($like) {
                $query->where('title', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhereHas('skus', function ($query) use ($like) {
                        $query->where('title', 'like', $like)
                            ->orWhere('description', 'like', $like);
                    });
            });
        }
        // 是否有提交 order 参数
        if ($order = $request->input('order', '')) {
            // 是否以 _asc 或者 _desc结尾
            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                if (in_array($m[1], ['price', 'sold_count', 'rating'])) {
                    $builder->orderBy($m[1], $m[2]);
                }
            }
        }
        $products = $builder->paginate(16);
        return view('products.index', [
            'products' => $products,
            'filters'  => [
                'search' => $search,
                'order'  => $order
            ]
        ]);
    }

    public function show(Product $product, Request $request)
    {
        // 如果商品未上架则抛出异常
        if (!$product->on_sale) {
            throw new InvalidRequestException('商品未上架');
        }
        $favored = false;
        if ($request->user()) {
            $favored = boolval($request->user()->favoriteProducts()->find($product->id));
        }
        return view('products.show', ['product' => $product, 'favored' => $favored]);
    }

    public function favor(Product $product, Request $request)
    {
        $user = $request->user();
        if ($user->favoriteProducts()->find($product->id)) {
            return [];
        }
        $user->favoriteProducts()->attach($product);
        return [];
    }

    public function disfavor(Product $product, Request $request)
    {
        $user = $request->user();
        $user->favoriteProducts()->detach($product);
        return [];
    }
}
