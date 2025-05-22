<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function getSlider(){
        try{
        $info = Slider::get();
        $customizedData = $info->map(function ($item) {
            return[
                'title' => $item->title,
                'image' => url($item->image),
            ];
        });
        return response()->json([
            'status' => 200,
            'data' => $customizedData,
               
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 400,
            "message" => "Something went wrong!",
            "error" => $e->getMessage(),
        ], 400);
    }
    
}
}
