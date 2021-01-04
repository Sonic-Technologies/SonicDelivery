<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Validator; 
use Illuminate\Support\Facades\DB;
use App\Mail\EmailConfirmation;
use Illuminate\Http\Request;
use App\Mail\CheckoutMail;
use App\OrderDetail;
use App\Customer;
use App\Barangay;
use App\Product;
use App\Order;
use Session;


class ProductController extends Controller
{
    public function showAllProducts()
    {
        $categories = DB::table('categories')->get();

        $items = DB::table('products')
                ->where('stat', '=', 'Active')
                ->get();

        return view('index', compact('categories', 'items'));
    }

    public function cart()
    {
        $barangay = DB::table('barangays')->orderBy('name', 'ASC')->get();

        return view('cart.cart', compact('barangay'));
    }

    public function getDeliveryFee($id)
    {
        $charge = Barangay::find($id);

        echo json_encode($charge);

        exit;
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::find($id);

        $this->validate($request, [
            'quantity' => 'required|numeric',
        ]);

        if($request->item_inventory < $request->quantity){
            abort(404);
        }

        $cart = session()->get('cart');

        if(!$cart){

            $cart = [
                $id => [
                    'item_code' => $product->artcode,
                    'item_name' => $product->artdesc,
                    'quantity' => $request->quantity,
                    'price' => $product->price,
                ]
            ];

            session()->put('cart', $cart);
            
            return redirect()->back();
        }

        $cart[$id] = [
            'item_code' => $product->artcode,
            'item_name' => $product->artdesc,
            'quantity' => $request->quantity,
            'price' => $product->price,
        ];

        session()->put('cart', $cart);
        
        return redirect()->back();
    }

    public function continueShopping(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'street' => 'required',
            'city' => 'required',
            'province' => 'required',
            'zip' => 'required',
        ]);
        
        $customer = session()->get('customer');
        
        $key = session_create_id();

        if(!$customer){
            $customer = [
                $key => [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'street' => $request->street,
                    'street2' => $request->street2,
                    'city' => $request->city,
                    'province' => $request->province,
                    'zip' => $request->zip,
                ]
            ];
            session()->put('customer', $customer);
            
            return redirect()->back();
        }
    }

    public function refreshCaptcha()
    {
        return captcha_img();
    }

    public function remove(Request $request)
    {
        if($request->id) {
 
            $cart = session()->get('cart');
 
            if(isset($cart[$request->id])) {
 
                unset($cart[$request->id]);
 
                session()->put('cart', $cart);
            }
 
            session()->flash('success', 'Product removed successfully');
        }
    }

    public function submitOrder(Request $request)
    {
        if(!Session::has('cart')){
            abort(404);
        }

        
        $cart = Session::get('cart');
        $cartItems = [];
        $cartItemsQty = [];
        $outOfStockItems = '';
        $a = '';
        $b = '';
        foreach($cart as $item)
        {
            $cartItems[] = $item['item_code'];
            $cartItemsQty[] = $item['quantity'];
        }

        for($i = 0; $i < sizeof($cartItems); $i++){
            $outOfStockItems = Product::where('artcode', '=', $cartItems[$i])
                                ->where('inventory', '<', $cartItemsQty[$i])
                                ->get();

            foreach($outOfStockItems as $items){
                $a = $items->artcode;
                $b = $items->inventory;
            }
    
            if($outOfStockItems != "[]"){
                return redirect()->back()->with('message', "Sorry, item ".$a." has ".$b."pc(s). left.");
            }
        }

        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|max:11',
            'barangay' => 'required',
            'street' => 'required',
            'city' => 'required',
            'province' => 'required',
            'zip' => 'required',
            'captcha' => 'required|captcha',
        ]);

        $customer = new Customer();
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->barangay = $request->barangay;
        $customer->street = $request->street;
        $customer->street2 = $request->street2;
        $customer->city = $request->city;
        $customer->province = $request->province;
        $customer->zip = $request->zip;
        $customer->save();

        $id = $customer->id;
        $barangay = $customer->barangay;

        DB::beginTransaction();

        $order = new Order();
        $order->customer_id = $id;
        $order->grand_total = $request->grand_total;
        $order->delivery_fee = $request->delivery_fee;
        $order->status = "new";
        $order->order_number = date("Ymd").$id;
        $order->order_date = date("Y-m-d");
        $order->save();
        $order_id = $order->id;

        $newInventory = '';
        $productId = '';
        foreach ($cart as $item) {
            $orderDetail = OrderDetail::create($item);
            $orderDetail->order_id = $order_id;
            $orderDetail->save();

            $products = DB::table('products')->where('artcode', '=', $orderDetail->item_code)->get();
            foreach($products as $prod){
                $newInventory = number_format($prod->inventory - $orderDetail->quantity);
                $productId = $prod->id;
            }
            $updateInventory = Product::find($productId);
            $updateInventory->inventory = $newInventory;
            $updateInventory->save();
        }

        DB::commit();

        $orderNumber = $order->order_number;

        $order_id = DB::table('orders')
                    ->where('customer_id', '=', $id)
                    ->value('id');

        $customer_order = DB::table('orders')
                        ->where('customer_id', '=', $id)
                        ->get();

        $customer_info = DB::table('orders')
                        ->where('customer_id', '=', $id)
                        ->join('customers', 'orders.customer_id', '=', 'customers.id')
                        ->select('orders.*', 'orders.id as item_id', 'customers.*')
                        ->get();

        $order_details = DB::table('order_details')
                        ->where('order_id', '=', $order_id)
                        ->join('orders', 'order_details.order_id', '=', 'orders.id')
                        ->select('order_details.*', 'orders.*')
                        ->get();

        $customer_barangay = DB::table('barangays')
                            ->where('id', '=', $barangay)
                            ->get();

        Mail::to(config('mail.order_to_address'))->send(new CheckoutMail($customer_order , $customer_info, $order_details, $customer_barangay));
        Mail::to($request->email)->send(new EmailConfirmation($customer_order , $customer_info, $order_details));
        
        $request->session()->flash('cart');
        $request->session()->flash('customer');

        return view('success', compact('orderNumber'));

    }
}
