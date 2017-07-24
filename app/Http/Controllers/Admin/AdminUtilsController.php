<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\Flashes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminUtilsController extends Controller
{
    use Flashes;

    public function clear_cache()
    {
        Cache::flush();

        $this->goodFlash('Cache cleared.');
        return redirect()->route('admin.orders');
    }
}
