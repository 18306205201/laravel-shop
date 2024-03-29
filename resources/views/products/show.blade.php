@extends('layouts.app')
@section('title', $product->title)

@section('content')
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card">
                <div class="card-body product-info">
                    <div class="row">
                        <div class="col-5">
                            <img src="{{ $product->image_url }}" alt="" class="cover">
                        </div>
                        <div class="col-7">
                            <div class="title">{{ $product->long_title ?: $product->title }}</div>
                            <div class="price"><label>价格</label><em>￥</em><span>{{ $product->price }}</span></div>
                            <div class="sales_and_reviews">
                                <div class="sold_count">累计销量 <span class="count">{{ $product->sold_count }}</span></div>
                                <div class="review_count">累计评价 <span class="count">{{ $product->review_count }}</span></div>
                                <div class="rating" title="评分 {{ $product->rating }}">评分 <span class="count">
                                        {{ str_repeat('★', floor($product->rating)) }}{{ str_repeat('☆', 5 - floor($product->rating)) }}
                                    </span></div>
                            </div>
                            <div class="skus">
                                <label>选择</label>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    @foreach($product->skus as $sku)
                                        <label class="btn sku-btn" title="{{ $sku->description }}" data-price="{{ $sku->price }}" data-stock="{{
                                        $sku->stock }}" data-toggle="tooltip" data-placement="bottom">
                                            <input type="radio" name="skus" autocomplete="off" value="{{ $sku->id }}">{{ $sku->title }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="cart_amount">
                                <label>数量</label>
                                <input type="text" class="form-control form-control-sm"><span>件</span><span class="stock"></span>
                            </div>
                            <div class="buttons">
                                @if($favored)
                                    <button class="btn btn-danger btn-disfavor">取消收藏</button>
                                @else
                                    <button class="btn btn-success btn-favor">❤ 收藏</button>
                                @endif
                                <button class="btn btn-primary btn-add-to-cart">加入购物车</button>
                            </div>
                        </div>
                    </div>
                    <div class="product-detail">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a href="#product-detail-tab" class="nav-link active" aria-controls="product-detail-tab" role="tab"
                                   data-toggle="tab" aria-selected="true">
                                    商品详情
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#product-reviews-tab" class="nav-link" aria-controls="product-reviews-tab" role="tab" data-toggle="tab"
                                   aria-selected="false">
                                    用户评价
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="product-detail-tab">
                                <!-- 产品属性开始-->
                                <div class="properties-list">
                                    <div class="properties-list-title">产品参数：</div>
                                    <ul class="properties-list-body">
                                       @foreach($product->grouped_properties as $name => $value)
                                           <li>{{ $name }}：{{ join(' ', $value) }}</li>
                                        @endforeach
                                    </ul>

                                </div>
                                <!-- 产品属性结束-->
                                <div class="product-description">
                                    {!! $product->description !!}
                                </div>

                            </div>
                            <div role="tabpanel" class="tab-pane" id="product-reviews-tab">

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop

@section('scriptsAfterJs')
    <script>
        $(document).ready(function() {
            // 选择商品切换
            $('[data-toggle=tooltip]').tooltip({trigger: 'hover'});
            $('.sku-btn').click(function () {
                $('.product-info .price span').text($(this).data('price'));
                $('.product-info .stock').text('库存：' + $(this).data('stock') + '件');
            });
            // 收藏
            $('.btn-favor').click(function () {
                axios.post('{{ route('products.favor', ['product' => $product->id]) }}')
                    .then(function() {
                        swal('操作成功', '', 'success')
                        .then(function() {
                            location.reload();
                        });
                    }, function (error) {
                        if (error.response && error.response.status === 401) {
                            swal('请先登陆', '', 'error');
                        } else if (error.response && (error.response.data.msg || error.response.data.message)) {
                            swal(error.response.data.msg ? error.response.data.msg : error.response.data.message, '', 'error');
                        } else {
                            swal('系统错误', '', 'error');
                        }
                    })
            });
            // 取消收藏
            $('.btn-disfavor').click(function () {
                axios.delete('{{ route('products.disfavor', ['product' => $product->id]) }}')
                    .then(function () {
                        swal('操作成功', '', 'success')
                            .then(function () {
                                location.reload();
                            });
                    });
            });
            // 加入购物车
            $('.btn-add-to-cart').click(function() {
                axios.post('{{ route('cart.add') }}', {
                    'sku_id': $('label.active input[name=skus]').val(),
                    'amount': $('.cart_amount input').val(),
                })
                    .then(function() {
                        swal('加入购物车成功', '', 'success')
                            .then(function() {
                                location.href = '{{ route('cart.index') }}';
                            });

                    }, function(error) {
                        if (error.response.status === 401) {
                            swal('请先登陆', '', 'error');
                        } else if (error.response.status === 422) {
                            // 参数校验失败
                            var html = '<div>';
                            _.each(error.response.data.errors, function(errors) {
                                _.each(errors, function(error) {
                                    html += error + '<br>';
                                });
                            });
                            html += '</div>';
                            swal({content: $(html)[0], icon: 'error'});
                        } else {
                            swal('系统错误', '', 'error');
                        }
                    });
            });
        });


    </script>
@endsection
