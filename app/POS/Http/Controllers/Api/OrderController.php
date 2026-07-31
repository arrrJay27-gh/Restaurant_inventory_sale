<?php

namespace App\POS\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\POS\Http\Requests\OrderRequest;
use App\POS\Services\OrderProcessingService;

class OrderController extends Controller
{
    public function store(OrderRequest $request, OrderProcessingService $service)
    {
        // Handle restaurant POS order submission from the front-end.
    }
}
