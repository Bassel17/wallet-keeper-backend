<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;

class CurrencyController extends Controller
{
    public function getAllCurrencies(){
        $currencies = Currency::all();

        return response()->json($currencies,200);
    }

    public function getCurrencyWithID($id){
        $currency = Currency::where('currency_id', $id)->get();
        return response()->json($currency,200);
    }    
}
