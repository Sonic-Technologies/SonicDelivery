<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\InventoryUpdate;
use App\Product;

class ImportExcelController extends Controller
{
    public function index()
    {
        $audits = DB::table('order_details')
                    ->join('orders', 'order_details.order_id', '=', 'orders.id')
                    ->select('order_details.item_code', 'order_details.item_name', 'order_details.quantity', 'orders.order_number', 'orders.order_date')
                    ->get();

        $updates = DB::table('inventory_updates')
                    ->join('products', 'inventory_updates.item_number', '=', 'products.artcode')
                    ->select('inventory_updates.*', 'products.artdesc')
                    ->get();

        return view('admin.import', compact('audits', 'updates'));
    }

    public function ImportExcel(Request $request)
    {

        $this->validate($request, [
            'file' => 'required|max:5000|mimes:xlsx',
        ]);

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load($request->file);
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();

        $itemCodes = [];
        $itemQuantities = [];
        $item = [];
        $quantity = [];
        $updatedItemCode = [];
        $stlnumber = $worksheet->getCellByColumnAndRow(8, 6)->getValue();
        //get item_codes & quantity from excel
        for($row = 1; $row <= $highestRow; ++$row){
            $item[] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
            $quantity[] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
        }
        //filter item_codes
        for($i = 0; $i < count($item); $i++){
            if(is_int($item[$i])){
                $itemCodes[] = $item[$i];
            }
        }
        //filter quantities
        for($i = 0; $i < count($quantity); $i++){
            if(is_int($quantity[$i])){
                $itemQuantities[] = $quantity[$i];
            }
        }

        DB::beginTransaction();
        //get products from filtered item_codes
        $product = Product::whereIn('artcode', $itemCodes)->get();
        //update inventory of products
        foreach($product as $prod){
            for($i = 0; $i < count($product); $i++){
                if($prod->artcode == $itemCodes[$i]){
                    $prod->inventory = number_format($prod->inventory + $itemQuantities[$i]);
                    $prod->save();
                    break;
                }
            }
        }
        //log inventory updates
        $id = Auth::id();
        for($i = 0; $i < count($itemCodes); $i++){
            $updates = new InventoryUpdate();
            $updates->item_number = $itemCodes[$i];
            $updates->quantity = $itemQuantities[$i];
            $updates->reference_number = $stlnumber;
            $updates->date = date("Y-m-d");
            $updates->user_id = $id;
            $updates->save();
        }
        DB::commit();
        return redirect('/import')->with('message', 'Import successful!');
    }

    public function filterAuditByDate(Request $request)
    {
        $this->validate($request, [
            'date' => 'required'
        ]);

        $audits = DB::table('order_details')
                    ->join('orders', 'order_details.order_id', '=', 'orders.id')
                    ->select('order_details.item_code', 'order_details.item_name', 'order_details.quantity', 'orders.order_number', 'orders.order_date')
                    ->where('orders.order_date', '=', $request->date)
                    ->get();

        $updates = DB::table('inventory_updates')
                    ->join('products', 'inventory_updates.item_number', '=', 'products.artcode')
                    ->select('inventory_updates.*', 'products.artdesc')
                    ->where('inventory_updates.date', '=', $request->date)
                    ->get();

        return view('admin.import', compact('audits', 'updates'));
    }
}
