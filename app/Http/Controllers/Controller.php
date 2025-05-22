<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemSizeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function filterItem(Request $request){
        $item_id  = $request->item_id;
        $item     = Item::where(['company_id'=>Session::get('company_id'),'id'=>$item_id])->first();
        // dd( $itemCurrentStock );
        if($item){
            return response()->json($item);
        }
    }

    public function filterItemSizeType(Request $request){
        $item_id  = $request->item_id;
        $sizeType = ItemSizeType::where(['company_id'=>Session::get('company_id'),'item_id'=>$item_id])->get();
        // dd( $itemCurrentStock );
        if(count($sizeType)>0){
            return response()->json($sizeType);
        }
    }

}
