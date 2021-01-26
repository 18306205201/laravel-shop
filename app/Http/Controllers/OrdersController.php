<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductSku;
use App\Models\UserAddress;
use Carbon\Carbon;
use App\Jobs\CloseOrder;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with(['orderItem.product', 'orderItem.productSku'])
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate();
        return view('orders.index', ['orders' => $orders]);
    }

    public function store(OrderRequest $request)
    {
        $user = $request->user();
        // 开启一个事务
        $order = \DB::transaction(function () use ($user, $request) {
            $address = UserAddress::find($request->address_id);
            // 更新此地址的最新使用时间
            $address->update(['last_used_at' => Carbon::now()]);
            // 创建一个订单
            $order = new Order([
                'address'      => [// 将地址信息放入订单中
                    'address'       => $address->full_address,
                    'zip'           => $address->zip,
                    'contact_name'  => $address->contact_name,
                    'contact_phone' => $address->contact_phone
                ],
                'remark'       => $request->remark,
                'total_amount' => 0,
            ]);
            // 订单关联到用户
            $order->user()->associate($user);
            $order->save();

            $totalAmount = 0;
            $items = $request->items;
            // 遍历用户提交的 sku
            foreach($items as $data) {
                $sku = ProductSku::find($data['sku_id']);
                $item = $order->orderItem()->make([
                    'amount' => $data['amount'],
                    'price' => $sku->price,
                ]);
                $item->product()->associate($sku->product_id);
                $item->productSku()->associate($sku);
                $item->save();
                $totalAmount += $sku->price * $data['amount'];
                if ($sku->decreaseStock($data['amount']) <= 0) {
                    throw new InvalidRequestException('该商品库存不足');
                }
            }
            // 更新订单总金额
            $order->update(['total_amount' => $totalAmount]);
            // 将下单的商品从购物车删除
            $skuIds = collect($items)->pluck('sku_id');
            $user->cartItems()->whereIn('product_sku_id', $skuIds)->delete();
            $this->dispatch(new CloseOrder($order, config('app.order_ttl')));
            return $order;
        });
        return $order;
    }

    public function show(Order $order, Request $request)
    {
        $this->authorize('own', $order);
        return view('orders.show', ['order' => $order->load(['orderItem.product', 'orderItem.productSku'])]);
    }
}
