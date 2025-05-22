<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function getNoticeList(){
        try {
            $notices = Notice::get();
            $customizedData = $notices->map(function ($item) {
                return[
                    'title' => $item->title,
                    'details' => $item->details,
                    'date' => $item->date,
                    'attachment' => url($item->attachment),
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
