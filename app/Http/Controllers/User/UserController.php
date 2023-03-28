<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{

    public function __construct()
    {
        $this->orderService = app('Service\OrderService');
    }

    public function index(Request $request)
    {
        $orders = Order::query()->where('email', Auth::user()->email)->orderByDesc('id')->paginate(10);
        $invite_count = User::query()->where('invite_user_id', Auth::id())->count();

        return $this->render('static_pages/user', compact('orders', 'invite_count'));
    }

}