<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Transaction;

use Exception;

class TransactionController extends Controller
{

    public function getUserTransactionsWithID($id){
        try{
            $transactions = Transaction::where('user_id',$id)->get();
            if($transaction == 0){
                return response()->json(['error'=> "user not found","status"=>404],404);
            }
            return response()->json($transactions,200);
        }catch(Exception $e){
            return response()->json(['error' => "server error","status"=>500],500);
        }
    }


    public function addTransaction(Request $request){
        try{
            $transaction = new Transaction;
            $transaction->title = $request->title;
            $transaction->description = $request->description;
            $transaction->amount = $request->amount;
            $transaction->interval = isset($request->interval) || null;
            $transaction->type = $request->type;
            $transaction->start_date = date('Y-m-d h:i:s', strtotime($request->start_date));
            $end_date_string = isset($request->end_date) ? date('Y-m-d h:i:s', strtotime($request->end_date)) : null;
            $transaction->end_date = $end_date_string;
            $transaction->category_id = $request->category_id;
            $transaction->user_id = $request->user_id;
            $transaction->currency_id = $request->currency_id;
            $result=$transaction->save();
            if($result == 0){
            return response()->json(['error'=>'transaction not added',"status"=>400],400);
            }
            return response()->json(['message'=>'successfully created transaction',"status"=>201],201);
        }catch(Exception $e){
            return response()->json(['error' => "server error","status"=>500],500);
        }
    }

    public function updateTransaction(Request $request){
        try{
            $id = $request->transaction_id;
            $title = $request->title;
            $description = $request->description;
            $amount = $request->amount;
            $interval = isset($request->interval) ? $request->interval:null;
            $start_date = date('Y-m-d h:i:s', strtotime($request->start_date));
            $end_date_string = isset($request->end_date) ? date('Y-m-d h:i:s', strtotime($request->end_date)) : null;
            $end_date = $end_date_string ;
            $currency_id = $request->currency_id;
            $transaction = Transaction::where('transaction_id',$id)->update([
                'title' => $title,
                'description' => $description,
                'amount' => $amount,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'currency_id' => $currency_id,
                'interval' => $interval
            ]);
            if($transaction == 0){
                return response()->json(['error'=>'transaction does not exist',"status"=>404],404);
            }
            return response()->json(['message'=>'successfully updated',"status"=>201],201);
        }catch(Exception $e){
            return response()->json(['error' => "server error","status"=>500],500);
        }
    }

    public function deleteTransaction(Request $request){
        try{
            $id = $request->transaction_id;
            $transaction = Transaction::where('transaction_id',$id)->delete();
            if($transaction == 0){
                return response()->json(['error'=>'transaction does not exist',"status"=>404],404);
            }
            return response()->json(['message'=>'successfully deleted',"status"=>200],200);
        }catch(Exception $e){
            return response()->json(['error' => "transaction not deleted ,server error","status"=>500],500);
        }
    }
}
