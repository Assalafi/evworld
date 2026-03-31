<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    //Transactions page load
    public function getTransactionsPageLoad() {
		
		$order_status_list = DB::table('order_status')->get();
		
		$datalist = DB::table('order_masters')
			->leftJoin('users', 'order_masters.customer_id', '=', 'users.id')
			->join('payment_method', 'order_masters.payment_method_id', '=', 'payment_method.id')
			->join('payment_status', 'order_masters.payment_status_id', '=', 'payment_status.id')
			->join('order_status', 'order_masters.order_status_id', '=', 'order_status.id')
			->select('order_masters.*', 'users.name', 'payment_method.method_name', 'payment_status.pstatus_name', 'order_status.ostatus_name')
			->orderBy('order_masters.created_at','desc')
			->paginate(25);

        return view('backend.transactions', compact('order_status_list', 'datalist'));		
	}
	
	//Get data for Transactions Pagination
	public function getTransactionsTableData(Request $request){

		$search = $request->search;
		$start_date = $request->start_date;
		$end_date = $request->end_date;
		
		if($request->ajax()){

			if($search != ''){
				$datalist = DB::table('order_masters')
					->leftJoin('users', 'order_masters.customer_id', '=', 'users.id')
					->join('payment_method', 'order_masters.payment_method_id', '=', 'payment_method.id')
					->join('payment_status', 'order_masters.payment_status_id', '=', 'payment_status.id')
					->join('order_status', 'order_masters.order_status_id', '=', 'order_status.id')
					->select('order_masters.*', 'users.name', 'payment_method.method_name', 'payment_status.pstatus_name', 'order_status.ostatus_name')
					->where(function ($query) use ($search){
						$query->where('order_masters.order_no', 'like', '%'.$search.'%')
							->orWhere('order_masters.transaction_no', 'like', '%'.$search.'%')
							->orWhere('order_masters.created_at', 'like', '%'.$search.'%')
							->orWhere('users.name', 'like', '%'.$search.'%')
							->orWhere('payment_method.method_name', 'like', '%'.$search.'%')
							->orWhere('payment_status.pstatus_name', 'like', '%'.$search.'%')
							->orWhere('order_status.ostatus_name', 'like', '%'.$search.'%')
							->orWhere('users.email', 'like', '%'.$search.'%');
					})
					->orderBy('order_masters.created_at','desc')
					->paginate(25);
			}else{
				if(($start_date != '') && ($end_date != '')){
					$datalist = DB::table('order_masters')
						->leftJoin('users', 'order_masters.customer_id', '=', 'users.id')
						->join('payment_method', 'order_masters.payment_method_id', '=', 'payment_method.id')
						->join('payment_status', 'order_masters.payment_status_id', '=', 'payment_status.id')
						->join('order_status', 'order_masters.order_status_id', '=', 'order_status.id')
						->select('order_masters.*', 'users.name', 'payment_method.method_name', 'payment_status.pstatus_name', 'order_status.ostatus_name')
						->whereBetween('order_masters.created_at', [$start_date, $end_date])
						->orderBy('order_masters.created_at','desc')
						->paginate(25);
				}else{
					$datalist = DB::table('order_masters')
						->leftJoin('users', 'order_masters.customer_id', '=', 'users.id')
						->join('payment_method', 'order_masters.payment_method_id', '=', 'payment_method.id')
						->join('payment_status', 'order_masters.payment_status_id', '=', 'payment_status.id')
						->join('order_status', 'order_masters.order_status_id', '=', 'order_status.id')
						->select('order_masters.*', 'users.name', 'payment_method.method_name', 'payment_status.pstatus_name', 'order_status.ostatus_name')
						->orderBy('order_masters.created_at','desc')
						->paginate(25);
				}
			}

			return view('backend.partials.transactions_table', compact('datalist'))->render();
		}
	}
}
