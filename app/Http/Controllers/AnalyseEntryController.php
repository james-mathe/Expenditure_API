<?php

namespace App\Http\Controllers;

use App\Models\Entries;
use Illuminate\Http\Request;

class AnalyseEntryController extends Controller
{
    public function Monthly(){

        $monthly = Entries :: select(Entries::raw('YEAR(created_at) as year'), Entries::raw('MONTH(created_at) as month'), Entries::raw('SUM(amount) as total'))
        ->groupBy('year', 'month')
        ->get();

        return $monthly;
    }

    public function Daily(){

        $daily = Entries::select(Entries::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as day"),Entries::raw("SUM(amount) as total"))
        ->groupBy('day')
        ->get();

        return $daily;
    }

    public function Category(){
        $category = Entries::select(Entries::raw('category_id as category_id'),Entries::raw("SUM(amount) as total"))
        ->groupBy('category_id')
        ->get();
        $num = $category->count();
        $totalByCat = 0;
        $total = 0;
        for($i = 0;$i < $num ;$i++){
            $total += $category[$i]->total;
        }
        $pourc = 100/$total;
        
        return $category;
        // return [
        //     "Categories"=>$category,
        //     "total"=>$total
        // ];
    }
}
