<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class OrdersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '订单';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order());
        $grid->model()->whereNotNull('paid_at')->orderBy('paid_at', 'desc');
        $grid->column('no', '订单流水号');
        $grid->column('user.name', '买家');
        $grid->column('total_amount', '总金额')->sortable();
        $grid->column('paid_at', '支付时间')->sortable();
        $grid->column('refund_status', '退款状态')->display(function ($value) {
            return Order::$refundStatusMap[$value];
        });
        $grid->column('ship_status', '物流')->display(function ($value) {
            return Order::$shipStatusMap[$value];
        });
        // 后台不需要创建订单
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            // 订单无法删除和编辑
            $actions->disableDelete();
            $actions->disableEdit();
        });
        $grid->tools(function ($tools) {
            // 禁用批量删除按钮
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });
        return $grid;
    }

    public function show($id, Content $content)
    {
        $order = Order::find($id);
        return $content
            ->header('查看订单')
            ->body(view('admin.orders.show', ['order' => $order]));
    }
}
