<?php

namespace App\Http\Controllers;

use App\Events\UpdateOrderStatus;


class TestController extends Controller
{
    public function test()
    {
        return UpdateOrderStatus::dispatch(['name' => 'krunal']);
    }
}
