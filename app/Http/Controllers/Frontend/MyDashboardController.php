<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MyDashboardController extends Controller
{
    public function LoadMyDashboard()
    {
        return view('frontend.my-dashboard');
    }
	
    public function LoadMyOrders()
    {
		$userid = 0;
		if(isset(Auth::user()->id)){
			$userid = Auth::user()->id;
		}
		
		$datalist = DB::table('order_masters')
			->join('payment_method', 'order_masters.payment_method_id', '=', 'payment_method.id')
			->join('payment_status', 'order_masters.payment_status_id', '=', 'payment_status.id')
			->join('order_status', 'order_masters.order_status_id', '=', 'order_status.id')
			->select('order_masters.*', 'payment_method.method_name', 'payment_status.pstatus_name', 'order_status.ostatus_name')
			->where('order_masters.customer_id', '=', $userid)
			->orderBy('order_masters.created_at','desc')
			->paginate(20);

        return view('frontend.my-orders', compact('datalist'));
    }
	
    public function MyOrderDetails($id, $order_no)
    {

		$mdata = DB::table('order_masters')
			->join('payment_method', 'order_masters.payment_method_id', '=', 'payment_method.id')
			->join('payment_status', 'order_masters.payment_status_id', '=', 'payment_status.id')
			->join('order_status', 'order_masters.order_status_id', '=', 'order_status.id')
			->select('order_masters.*', 'payment_method.method_name', 'order_masters.payment_status_id', 'payment_status.pstatus_name', 'order_masters.order_status_id', 'order_status.ostatus_name', 'order_masters.name as customer_name', 'order_masters.email as customer_email', 'order_masters.phone as customer_phone', 'order_masters.address as customer_address')
			->where('order_masters.id', $id)
			->first();
			
		$datalist = DB::table('order_items')
			->join('products', 'order_items.product_id', '=', 'products.id')
			->select('order_items.*', 'products.title', 'products.f_thumbnail', 'products.id')
			->where('order_items.order_master_id', $id)
			->get();
			
        return view('frontend.order-details', compact('mdata', 'datalist'));
    }
	
    public function LoadMyProfile()
    {
        return view('frontend.my-profile');
    }
	
	public function UpdateProfile(Request $request)
    {
		$gtext = gtext();
		
		$id = $request->input('user_id');
		
		$secretkey = $gtext['secretkey'];
		$recaptcha = $gtext['is_recaptcha'];
		if($recaptcha == 1){
			$request->validate([
				'g-recaptcha-response' => 'required',
				'name' => 'required',
				'email' => 'required',
			]);
			
			$captcha = $request->input('g-recaptcha-response');

			$ip = $_SERVER['REMOTE_ADDR'];
			$url = 'https://www.google.com/recaptcha/api/siteverify?secret='.urlencode($secretkey).'&response='.urlencode($captcha).'&remoteip'.$ip;
			$response = file_get_contents($url);
			$responseKeys = json_decode($response, true);
			if($responseKeys["success"] == false) {
				return redirect("user/register")->withFail(__('The recaptcha field is required'));
			}
		}else{
			$request->validate([
				'name' => 'required',
				'email' => 'required',
			]);
		}
		
		$data = array(
			'name' => $request->input('name'),
			'phone' => $request->input('phone'),
			'address' => $request->input('address')
		);

		$response = User::where('id', $id)->update($data);
		
		if($response){
			return redirect()->back()->withSuccess(__('Data Updated Successfully'));
		}else{
			return redirect()->back()->withFail(__('Data update failed'));
		}
    }
	
    public function LoadChangePassword()
    {
        return view('frontend.change-password');
    }
	
	public function ChangePassword(Request $request)
    {
		$gtext = gtext();

		$secretkey = $gtext['secretkey'];
		$recaptcha = $gtext['is_recaptcha'];
		if($recaptcha == 1){
			$request->validate([
				'g-recaptcha-response' => 'required',
				'current_password' => 'required',
				'password' => 'required|confirmed|min:6',
				'password_confirmation' => 'required'
			]);
			
			$captcha = $request->input('g-recaptcha-response');

			$ip = $_SERVER['REMOTE_ADDR'];
			$url = 'https://www.google.com/recaptcha/api/siteverify?secret='.urlencode($secretkey).'&response='.urlencode($captcha).'&remoteip'.$ip;
			$response = file_get_contents($url);
			$responseKeys = json_decode($response, true);
			if($responseKeys["success"] == false) {
				return redirect("user/register")->withFail(__('The recaptcha field is required'));
			}
		}else{
			$request->validate([
				'current_password' => 'required',
				'password' => 'required|confirmed|min:6',
				'password_confirmation' => 'required'
			]);
		}

       $hashedPassword = Auth::user()->password;
 
       if (\Hash::check($request->input('current_password'), $hashedPassword )) {
 
			if (!\Hash::check($request->input('password'), $hashedPassword)) {

				$id = Auth::user()->id;

				$data = array(
					'password' => Hash::make($request->input('password')),
					'bactive' => base64_encode($request->input('password'))
				);
				
				$response = User::where('id', $id)->update($data);
				
				if($response){
					return redirect()->back()->withSuccess(__('Your password changed successfully'));
				}else{
					return redirect()->back()->withFail(__('Oops! You are failed change password. Please try again'));
				}
			}else{
				
				return redirect()->back()->withFail(__('New password can not be the old password!'));
			}
 
        }else{
			return redirect()->back()->withFail(__('Current password does not match.'));
		}
	}	
}
