<?php

namespace App\POS\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index(Request $request)
    {
        // Return restaurant menu item list for the POS front-end screen.
    }

    public function show(int $id)
    {
        // Return a single menu item detail.
    }
}
