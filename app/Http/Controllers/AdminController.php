<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\InventoryUpdate;
use App\Categories;
use App\Product;
use App\Order;


class AdminController extends Controller
{

    public function dashboard()
    {
        $items = DB::table('products')->where('stat', '=', 'Active')->get()->count();
        $items2 = DB::table('products')->where('stat', '=', 'Inactive')->get()->count();
        $items3 = DB::table('orders')->where('status', '=', 'new')->get()->count();
        $items4 = DB::table('products')->where('inventory', '>', '0')->where('stat', '=', 'Active')->get()->count();
        $items5 = DB::table('products')->where('inventory', '=', '0')->where('stat', '=', 'Active')->get()->count();

        return view('admin.dashboard', compact('items', 'items2', 'items3', 'items4','items5'));
    }

    public function orders()
    {
        return view('admin.orders');
    }

    public function getAllProducts()
    {
        $categories = DB::table('categories')->get();

        $items = DB::table('products')->where('stat', '=', 'Active')->get();

        return view('admin.products', compact('categories', 'items'));
    }

    public function searchItem(Request $request)
    {

        $this->validate($request, [
            'itemcode' => 'required',
        ]);

        $item = DB::table('products')->where('artcode', '=', $request->itemcode)->get();

        $categories = DB::table('categories')->get();

        return view('admin.search', compact('item', 'categories'));
    }

    public function categorize(Request $request)
    {
        $categories = DB::table('categories')->get();

        $category = Categories::find($request->filter);

        $items = DB::table('products')
                ->where('subcat', '=', $category->description)
                ->get();

        return view('admin.products', compact('items', 'categories'));
    }

    public function getItem($id)
    {
        $item = DB::table('products')->where('id', '=', $id)->get();

        $categories = DB::table('categories')->get();

        return view('admin.search', compact('item', 'categories'));
    }

    public function updateItem(Request $request, $id)
    {
        $item = Product::find($id);
        
        $category = Categories::find($request['itemCategory']);

        $this->validate($request, [
            'itemCode' => 'required',
            'itemName' => 'required',
            'itemCategory' => 'nullable',
            'itemPrice' => 'required',
            'itemStatus' => 'required',
            'itemPhoto' => 'nullable',
            'inventory' => 'required',
        ]);

        $item->artcode = $request['itemCode'];
        $item->artdesc = $request['itemName'];
        $item->price = $request['itemPrice'];
        $item->stat = $request['itemStatus'];
        $item->inventory = $request['inventory'];

        if($request['itemCategory'] != ""){
            $item->subcat = $category->description;
        }
        if($request->hasFile('itemPhoto')){
            $path = $request->itemPhoto->store('', config('filesystems.storage_disk'));
            $item->photo = $path;
        }

        $item->save();

        $id = Auth::id();

        $update = new InventoryUpdate();
        $update->item_number = $request['itemCode'];
        $update->quantity = $request['inventory'];
        $update->date = date("Y-m-d");
        $update->user_id = $id;
        $update->reference_number = "User-".$id;
        $update->save();

        return redirect('/products');
    }

    public function getOrders()
    {
        $newOrder = DB::table('orders')
                    ->where('status', '=', 'new')
                    ->join('customers', 'orders.customer_id', '=', 'customers.id')
                    ->select('customers.id', 'customers.first_name', 'customers.last_name', 'orders.created_at')
                    ->paginate(10);

        $confirmedOrder = DB::table('orders')
                            ->where('status', '=', 'confirmed')
                            ->join('customers', 'orders.customer_id', '=', 'customers.id')
                            ->select('customers.id','customers.first_name', 'customers.last_name', 'orders.created_at')
                            ->paginate(10);

        return view('admin.orders', compact('newOrder', 'confirmedOrder'));
    }

    public function getCustomerOrder($id)
    {
        $orders = DB::table('orders')
                    ->where('customer_id', '=', $id)
                    ->value('id');

        $getCustomer = DB::table('orders')
                        ->where('customer_id', '=', $id)
                        ->join('customers', 'orders.customer_id', '=', 'customers.id')
                        ->select('orders.*', 'orders.id as item_id', 'customers.*')
                        ->get();
        
        $getOrderDetails = DB::table('order_details')
                            ->where('order_id', '=', $orders)
                            ->join('orders', 'order_details.order_id', '=', 'orders.id')
                            ->select('order_details.*', 'orders.*')
                            ->get();
        // return $getCustomer;    
        return view('admin.user-order', compact('getCustomer', 'getOrderDetails'));
    }

    public function confirmOrder($id)
    {
        $order = Order::find($id);

        $order->status = "confirmed";
        $order->save();

        return redirect('/orders');
    }
}
