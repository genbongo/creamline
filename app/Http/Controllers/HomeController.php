<?php

namespace App\Http\Controllers;

use App\Product;
use App\Rules\MatchOldPassword;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.home');
    }

    /*
    * Create a function that will navigate the user to profile page
    */
    public function profile()
    {
        return view('profile.index');
    }

    /*
    * Create a function that will upload a profile picture
    */
    public function profile_upload(Request $request)
    {
        //check if there is an ajax request
        if($request->ajax()){
            $validation = Validator::make($request->all(), [
                'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
            ]);

            if($validation->passes())
            {
                $image = $request->file('img');
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('img/profile'), $new_name);

                User::updateOrCreate([
                    'id' => $request->user_id
                ],[
                    'img' => $new_name,
                ]);

                return response()->json([
                    'message'   => 'Image Upload Successfully',
                    'uploaded_image' => url('img/profile').'/'.$new_name,
                ]);
            }
            else
            {
                return response()->json([
                    'message'   => $validation->errors()->all(),
                ]);
            }
        }
        
    }

    /*
    * Create a function that will update a profile
    */
    public function profile_update(Request $request)
    {
        User::updateOrCreate([
            'id' => $request->user_id
        ],[
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'address' => $request->address,
            'contact_num' => $request->contact_num,
        ]);

        return response()->json([
            'message'   => 'Profile Successfully Updated!',
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'address' => $request->address,
            'contact_num' => $request->contact_num,
        ]);
    }

    /*
    * Create a function that will reset a password
    */
    public function profile_pass_reset(Request $request)
    {
        $request->validate([
            'old_password' => ['required', new MatchOldPassword],
            'password' => ['required'],
            'confirm' => ['same:password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->password)]);

        return response()->json([
            'message'   => 'Password Successfuly Changed',
        ]);
    }

    /*
    * Create a function display the count of Orders to deliver
    */
    public function display_order_to_deliver_count(){
        $getOrderToDeliverCount = Order::where('is_approved', '=' ,'1')
              ->where('delivery_date', '=', \Carbon::now())
              ->count();

        return response()->json([
            'count'   => $getOrderToDeliverCount[0],
            'status'  => 200
        ]);
    }

    /*
    * Create a function display the count of Orders to approve
    */
    public function display_order_to_approve_count(){
        if(env("DB_CONNECTION") == "pgsql"){
            $getOrderToApproveCount = DB::select("SELECT COUNT(*) as data FROM orders WHERE is_approved = '0'");
        }else{
            $getOrderToApproveCount = DB::select('SELECT COUNT(*) as data FROM orders WHERE is_approved = 0');
        }
        
        return response()->json([
            'count'   => $getOrderToApproveCount[0],
            'status'  => 200
        ]);
    }

    /*
    * Create a function display the count of products out of stocks
    */
    public function display_out_of_stocks_product_count(){
        if(env("DB_CONNECTION") == "pgsql"){
            $getOutOfStocksProduct = DB::select("SELECT COUNT(*) as data FROM stocks WHERE quantity < threshold");
        }else{
            $getOutOfStocksProduct = DB::select('SELECT COUNT(*) as data FROM stocks WHERE quantity < threshold');
        }
        
        return response()->json([
            'count'   => $getOutOfStocksProduct[0],
            'status'  => 200
        ]);
    }

    /*
    * Create a function display the product of the month
    */
    public function display_product_of_the_month(){
        if(env("DB_CONNECTION") == "pgsql"){
            $getProductOfTheMonth = DB::select("SELECT name FROM orders INNER JOIN products ON orders.product_id = products.id WHERE EXTRACT(MONTH FROM delivery_date) = EXTRACT(MONTH FROM CURRENT_DATE) GROUP BY name ORDER BY COUNT(name) DESC LIMIT 1");
            $getProductOfTheMonthImage = DB::select("SELECT product_image FROM orders INNER JOIN products ON orders.product_id = products.id WHERE EXTRACT(MONTH FROM delivery_date) = EXTRACT(MONTH FROM CURRENT_DATE) GROUP BY product_image ORDER BY COUNT(product_image) DESC LIMIT 1");
        }else{
            $getProductOfTheMonth = DB::select('SELECT name FROM orders INNER JOIN products ON orders.product_id = products.id WHERE month(delivery_date) = MONTH(CURDATE()) GROUP BY name ORDER BY COUNT(name) DESC LIMIT 1');
            $getProductOfTheMonthImage = DB::select('SELECT product_image FROM orders INNER JOIN products ON orders.product_id = products.id WHERE month(delivery_date) = MONTH(CURDATE()) GROUP BY product_image ORDER BY COUNT(product_image) DESC LIMIT 1');
        }
        
        return response()->json([
            'data'   => $getProductOfTheMonth[0],
            'img'   => $getProductOfTheMonthImage[0],
            'status'  => 200
        ]);
    }

    /*
    * Create a function display the weekly sales data
    */
    public function display_weekly_sales_data(Request $request){

        $sun = DB::select("SELECT COUNT(*) as counts FROM orders WHERE delivery_date = '".$request->input("sunday")."' AND is_completed = '1' AND is_replacement = '0' ");
        $mon = DB::select("SELECT COUNT(*) as counts FROM orders WHERE delivery_date = '".$request->input("monday")."' AND is_completed = '1' AND is_replacement = '0' ");
        $tue = DB::select("SELECT COUNT(*) as counts FROM orders WHERE delivery_date = '".$request->input("tuesday")."' AND is_completed = '1' AND is_replacement = '0' ");
        $wed = DB::select("SELECT COUNT(*) as counts FROM orders WHERE delivery_date = '".$request->input("wednesday")."' AND is_completed = '1' AND is_replacement = '0' ");
        $thu = DB::select("SELECT COUNT(*) as counts FROM orders WHERE delivery_date = '".$request->input("thursday")."' AND is_completed = '1' AND is_replacement = '0' ");
        $fri = DB::select("SELECT COUNT(*) as counts FROM orders WHERE delivery_date = '".$request->input("friday")."' AND is_completed = '1' AND is_replacement = '0' ");
        $sat = DB::select("SELECT COUNT(*) as counts FROM orders WHERE delivery_date = '".$request->input("saturday")."' AND is_completed = '1' AND is_replacement = '0' ");
        
        return response()->json([
            "sun"   =>      $sun[0],
            "mon"   =>      $mon[0],
            "tue"   =>      $tue[0],
            "wed"   =>      $wed[0],
            "thu"   =>      $thu[0],
            "fri"   =>      $fri[0],
            "sat"   =>      $sat[0],
        ]);
    }

    /*
    * Create a function display the sales data
    */
    public function display_sales_data(Request $request){

        $data = DB::select("SELECT COUNT(*) as counts FROM orders WHERE is_completed = '1' AND is_replacement = '0' ");
        
        return response()->json([
            "data"   =>      $data[0]
        ]);
    }

    /*
    * Create a function display the loss data
    */
    public function display_loss_data(Request $request){

        $data = DB::select("SELECT COUNT(*) as counts FROM orders WHERE is_completed = '1' AND is_replacement = '1' ");
        
        return response()->json([
            "data"   =>      $data[0]
        ]);
    }




    /*
    * Create a function display the count of Orders to receive for client
    */
    public function display_order_to_receive_count_for_client(){
        if(env("DB_CONNECTION") == "pgsql"){
            $getOrderToDeliverCount = DB::select('SELECT COUNT(*) as data FROM orders WHERE is_approved = "1" AND client_id = "'.Auth::user()->id.'" AND delivery_date = CURRENT_DATE');
        }else{
            $getOrderToDeliverCount = DB::select('SELECT COUNT(*) as data FROM orders WHERE is_approved = 1 AND client_id = "'.Auth::user()->id.'" AND delivery_date = CURDATE()');
        }

        return response()->json([
            'count'   => $getOrderToDeliverCount[0],
            'status'  => 200
        ]);
    }

    public function lowStocks()
    {
        $products =  Product::with('stock')->get();

        $lowStocks = $products->filter(function ($product) {
            return $product->stock->quantity < $product->stock->threshold;
        });

        return response()->json([
            'count'   => $lowStocks->count(),
            'status'  => 200
        ]);
    }

    /*
    * Create a function display the count of Orders to approve for the specific client
    */
    public function display_order_to_approve_count_for_client(){
        if(env("DB_CONNECTION") == "pgsql"){
            $getOrderToApproveCount = DB::select('SELECT COUNT(*) as data FROM orders WHERE is_approved = "0" AND client_id = "'.Auth::user()->id.'" ');
        }else{
            $getOrderToApproveCount = DB::select('SELECT COUNT(*) as data FROM orders WHERE is_approved = 0 AND client_id = "'.Auth::user()->id.'" ');
        }
        
        return response()->json([
            'count'   => $getOrderToApproveCount[0],
            'status'  => 200
        ]);
    }

    /*
    * Create a function display the product of the month
    */
    public function display_3_best_product_of_the_month(){
        if(env("DB_CONNECTION") == "pgsql"){
            $getProductOfTheMonth = DB::select("SELECT name FROM orders INNER JOIN products ON orders.product_id = products.id WHERE EXTRACT(MONTH FROM delivery_date) = EXTRACT(MONTH FROM CURRENT_DATE) GROUP BY name ORDER BY COUNT(name) DESC LIMIT 3");
            $getProductOfTheMonthImage = DB::select("SELECT product_image FROM orders INNER JOIN products ON orders.product_id = products.id WHERE EXTRACT(MONTH FROM delivery_date) = EXTRACT(MONTH FROM CURRENT_DATE) GROUP BY product_image ORDER BY COUNT(product_image) DESC LIMIT 3");
        }else{
            $getProductOfTheMonth = DB::select('SELECT name FROM orders INNER JOIN products ON orders.product_id = products.id WHERE month(delivery_date) = MONTH(CURDATE()) GROUP BY name ORDER BY COUNT(name) DESC LIMIT 3');
            $getProductOfTheMonthImage = DB::select('SELECT product_image FROM orders INNER JOIN products ON orders.product_id = products.id WHERE month(delivery_date) = MONTH(CURDATE()) GROUP BY product_image ORDER BY COUNT(product_image) DESC LIMIT 3');
        }
        
        return response()->json([
            'data1'   => array_key_exists(0, $getProductOfTheMonth) ? $getProductOfTheMonth[0] : "....",
            'img1'   => array_key_exists(0, $getProductOfTheMonthImage) ? $getProductOfTheMonthImage[0] : "default.jpg",
            'data2'   => array_key_exists(1, $getProductOfTheMonth) ? $getProductOfTheMonth[1] : "....",
            'img2'   => array_key_exists(1, $getProductOfTheMonthImage) ? $getProductOfTheMonthImage[1] : "default.jpg",
            'data3'   => array_key_exists(2, $getProductOfTheMonth) ? $getProductOfTheMonth[2] : "....",
            'img3'   => array_key_exists(2, $getProductOfTheMonthImage) ? $getProductOfTheMonthImage[2] : "default.jpg",
            'status'  => 200
        ]);
    }
}
