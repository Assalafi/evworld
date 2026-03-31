<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_master extends Model
{
    use HasFactory;
	
	protected $table = 'order_masters';
	
    protected $fillable = [
	  'order_no',
	  'transaction_no',
	  'customer_id',
	  'payment_method_id',
	  'payment_status_id',
	  'order_status_id',
	  'total_qty',
	  'total_price',
	  'discount',
	  'tax',
	  'subtotal',
	  'total_amount',
	  'shipping_title',
	  'shipping_fee',
	  'name',
	  'email',
	  'phone',
	  'country',
	  'state',
	  'city',
	  'address',
	  'comments',
    ];	
}
