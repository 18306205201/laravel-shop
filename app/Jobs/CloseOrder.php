<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CloseOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order, $delay)
    {
        $this->order = $order;
        // 设置延迟时间，delay 方法的参数代表多少秒后去执行
        $this->delay($delay);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 订单已被支付则不需要处理
        if ($this->order->paid_at) {
            return;
        }
        // 通过事务去执行 sql
        \DB::transaction(function() {
            // 将订单的 closed 字段改为 true, 即关闭订单
            $this->order->update(['closed' => true]);
            // 循环遍历商品中的 SKU，将订单中的数量退回到 SKU 的库存中去
            foreach($this->order->orderItem as $item) {
                $item->productSku->addStock($item->amount);
            }
        });

    }
}
