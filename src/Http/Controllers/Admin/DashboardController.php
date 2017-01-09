<?php

namespace Privateer\Fabric\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Privateer\Fabric\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function show()
    {
        return view('fabric::admin.dashboard.show');
    }
}
