<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class InventoryController extends Controller
{
	//insert
    public function store(Request $request){

    	if($request->input('item') 
    		&&  $request->input('optype')
    		&&  $request->input('quantity')
    	){
    		$item = $request->input('item');
    		$optype = $request->input('optype');
    		$quantity = $request->input('quantity');
    		//first check balaance from stock_balance table
    		$stock_balance = DB::table('stock_balances')
    		->select('balance_quantity')
    		->where('item_id', $item)
    		->first();

    		
    		$balance = isset($stock_balance)?$stock_balance->balance_quantity:0;

    		if(($balance-$quantity) < 0 && $optype == 2){
    			return "Item is not availabe";
    		}else{

	    		$balance = $optype == 1 ? $balance+$quantity : $balance - $quantity;    		
	    		//optype = operation type 1 means in,2 means out
	    		DB::beginTransaction();
	    		try{

	    			DB::table('stocks')->insert([
	    				'item_id'=>$item,
	    				'quantity'=>$quantity,
	    				'op_type'=>$optype
	    			]);
	    			if(isset($stock_balance)){    				
	    				DB::table('stock_balances')
			            ->where('item_id', $item)
			            ->update(['balance_quantity' => $balance,'op_type'=>$optype]);

	    			}else{
		    			DB::table('stock_balances')->insert([
		    				'item_id'=>$item,
		    				'balance_quantity'=>$balance,
		    				'op_type'=>$optype
		    			]);
	    			}

	    			DB::commit();	

	    		}catch(Exception $e){
	    			DB::rollBack();
	    		}
    		}	

    	}

    	//test purpor : stock?item=1&optype=2&quantity=4
    	//test purpor : stock?item=1&optype=1&quantity=10

    	return "MARA KHA";

    }

    //individual stock update
    public function udapte(Request $request, $id){

    	if(    		
    		$request->input('quantity')
    	){    		
    		
    		
    		$quantity = $request->input('quantity');
    		//first query the stock table to get product id
    		$stock = DB::table('stocks')->select('item_id','quantity','op_type')->where('id', $id)
    		->first();

    		$item  = $stock->item_id;
    		$quantityBalance = $quantity - $stock->quantity;
    		$optype = $stock->op_type;
    		//dd($quantityBalance);
    		//first check balaance from stock_balance table
    		$stock_balance = DB::table('stock_balances')
    		->select('balance_quantity')
    		->where('item_id', $item)
    		->first();

    		 

    		
    		$balance = isset($stock_balance)?$stock_balance->balance_quantity:0;

    		if(($balance-$quantityBalance) < 0 && $optype == 2){
    			return "Item is not availabe";
    		}else{

	    		$balance = $optype == 1 ? $balance+$quantityBalance : $balance - $quantityBalance;    		
	    		//optype = operation type 1 means in,2 means out
	    		DB::beginTransaction();
	    		try{
	    			

	    			DB::table('stocks')
		            ->where('id', $id)
		            ->update(['quantity'=>$quantity]);
	    			   				
    				DB::table('stock_balances')
		            ->where('item_id', $item)
		            ->update(['balance_quantity' => $balance,'op_type'=>$optype]);

	    			

	    			DB::commit();	

	    		}catch(Exception $e){
	    			DB::rollBack();
	    		}
    		}	

    	}

    	//test purpor : stock/1?quantity=10    	

    	return "ARO MARA KHA";

    }

    //delete id and effect inventory balance
    public function delete($id){

    	//first query the stock table to get product id
		$stock = DB::table('stocks')->select('item_id','quantity','op_type')->where('id', $id)
		->first();

		if(!isset($stock))
			return redirect(400);

		$item  = $stock->item_id;
		$quantity = $stock->quantity;
		$optype = $stock->op_type;		
		//first check balaance from stock_balance table
		$stock_balance = DB::table('stock_balances')
		->select('balance_quantity')
		->where('item_id', $item)
		->first();

		$balance = isset($stock_balance)?$stock_balance->balance_quantity:0;
		
		//dd($balance);
		if(($balance-$quantity) < 0 && $optype == 1){
    			return "Item is not availabe";
    	}else{

    		$balance = $optype == 1 ? $balance - $quantity : $balance + $quantity;
			DB::beginTransaction();
			try{
				
				DB::table('stocks')->where('id', $id)->delete();			
				   				
				DB::table('stock_balances')
	            ->where('item_id', $item)
	            ->update(['balance_quantity' => $balance,'op_type'=>$optype]);

				

				DB::commit();	

			}catch(Exception $e){
				DB::rollBack();
			}
		}

		//test purpor : stock/d/8

		return "OBOSESH MARA KHAWA";
    }

    //balance summary query
    //SELECT item_id, (SELECT name from items where items.id = item_id) Item_Name,IF(op_type=1,'IN', 'OUT') as Operation_Type,SUM(quantity) Quantity FROM `stocks` GROUP by item_id, op_type
}
