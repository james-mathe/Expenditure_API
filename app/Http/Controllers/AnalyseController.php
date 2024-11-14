<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnalyseResource;
use App\Models\Expenditure;
use Illuminate\Http\Request;

class AnalyseController extends Controller
{
    public function Monthly(){

        $monthly = Expenditure :: select(Expenditure::raw('YEAR(created_at) as year'), Expenditure::raw('MONTH(created_at) as month'), Expenditure::raw('SUM(amount) as total'))
        ->groupBy('year', 'month')
        ->get();

        return $monthly;
    }

    public function Daily(){

        $daily = Expenditure::select(Expenditure::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as day"),Expenditure::raw("SUM(amount) as total"))
        ->groupBy('day')
        ->get();

        return $daily;
    }

    public function Category(){
        $category = Expenditure::select(Expenditure::raw('category_id as category_id'),Expenditure::raw("SUM(amount) as total"))
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
