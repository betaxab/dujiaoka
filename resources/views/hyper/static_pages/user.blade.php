@extends('hyper.layouts.default')

@section('content')
<div class="row mt-3">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <div class="avatar-sm rounded">
                            <span class="avatar-title bg-primary-lighten h3 my-0 text-primary rounded">
                                <i class="mdi mdi-currency-usd"></i>
                            </span>
                        </div>
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h4 class="mt-0 mb-1 font-20">{{ __('hyper.user_balance') }}</h4>
                        <p class="mb-0 text-muted">{{ __('hyper.global_currency') }}{{ Auth::user()->balance }}</p>
                    </div>
                </div>
                <div class="row align-items-end justify-content-between mt-3">
                    <div class="col-sm-6">
                        <p class="text-muted mb-0">{{ __('hyper.user_balance_note') }}</p>
                    </div> <!-- end col -->

                    <div class="col-sm-5">
                        <a class="btn btn-sm btn-primary float-right" href="#">{{ __('hyper.user_topup') }}</a>
                    </div> <!-- end col -->
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <div class="avatar-sm rounded">
                            <span class="avatar-title bg-primary-lighten h3 my-0 text-primary rounded">
                                <i class="mdi mdi-account-multiple-plus-outline"></i>
                            </span>
                        </div>
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h4 class="mt-0 mb-1 font-20">{{ __('hyper.user_commission_order') }}</h4>
                        <p class="mb-0 text-muted"><i class="mdi mdi-arrow-up-bold text-success"></i> {{ $invite_count }}</p>
                    </div>
                </div>
                <div class="row align-items-end justify-content-between mt-3">
                    <div class="col-sm-6">
                        <p class="text-muted mb-0">{{ __('hyper.user_commission_order_note') }}</p>
                    </div> <!-- end col -->

                    <div class="col-sm-5">
                        <a class="btn btn-sm btn-primary float-right" href="#">{{ __('hyper.user_view_invitation') }}</a>
                    </div> <!-- end col -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- start page tatle -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">{{ __('hyper.user_order_list_title') }}</h4>
        </div>
    </div>
</div>
<!-- end page tatle -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('hyper.bill_order_number') }}</th>
                                <th>{{ __('hyper.bill_product_name') }}</th>
                                <th>{{ __('hyper.user_payment_amount') }}</th>
                                <th>{{ __('hyper.orderinfo_order_status') }}</th>
                                <th>{{ __('hyper.user_creation_time') }}</th>
                                <th>{{ __('hyper.user_action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->order_sn }}</td>
                                <td>{{ $order->title }}</td>
                                <td class="text-primary">{{ __('hyper.global_currency') }}{{ $order->actual_price }}</td>
                                <td>
                                    @switch($order->status)
                                    @case(\App\Models\Order::STATUS_EXPIRED)
                                    <h5 class="my-0"><span class="badge badge-danger-lighten">{{ __('hyper.orderinfo_status_expired') }}</span></h5>
                                    @break
                                    @case(\App\Models\Order::STATUS_WAIT_PAY)
                                    <label class="badge badge-info-lighten">{{ __('hyper.orderinfo_status_wait_pay') }}</label>
                                    @break
                                    @case(\App\Models\Order::STATUS_PENDING)
                                    <label class="badge badge-warning-lighten">{{ __('hyper.orderinfo_status_pending') }}</label>
                                    @break
                                    @case(\App\Models\Order::STATUS_PROCESSING)
                                    <label class="badge badge-primary-lighten">{{ __('hyper.orderinfo_status_processed') }}</label>
                                    @break
                                    @case(\App\Models\Order::STATUS_COMPLETED)
                                    <label class="badge badge-primary-lighten">{{ __('hyper.orderinfo_status_completed') }}</label>
                                    @break
                                    @case(\App\Models\Order::STATUS_FAILURE)
                                    <label class="badge badge-danger-lighten">{{ __('hyper.orderinfo_status_failed') }}</label>
                                    @break
                                    @case(\App\Models\Order::STATUS_FAILURE)
                                    <label class="badge badge-dark-lighten">{{ __('hyper.orderinfo_status_abnormal') }}</label>
                                    @break
                                    @endswitch
                                </td>
                                <td>{{ $order->created_at }}</td>
                                <td>
                                    <form action="/search-order-by-sn" method="post">
                                        <input type="hidden" class="form-control" name="order_sn" value="{{ $order->order_sn }}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="action-icon btn"><i class="mdi mdi-eye"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
<!-- end row -->
@stop
@section('js')
@stop
