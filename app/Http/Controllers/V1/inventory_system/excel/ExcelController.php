<?php

namespace App\Http\Controllers\V1\inventory_system\excel;

use App\Exports\ItemsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function items(){
        return Excel::download(new ItemsExport(), 'items.xlsx');
    }
}
