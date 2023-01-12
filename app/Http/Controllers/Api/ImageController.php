<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function getImage($path)
    {
        if($image = Storage::get('public/file/'.$path))
        {   
            return response($image)->header("Content-Type", Storage::mimeType('public/file/'.$path)."; charset=UTF-8");
        }else
            return response()->json([
                'status' => 404,
                'success' => false,
                'path' => $path
            ], 404);
    }
}
