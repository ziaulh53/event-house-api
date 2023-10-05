<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class FileUploadController extends Controller
{
    public function storeUploads(Request $request)
    {
        $imageUrl =  Cloudinary::upload($request->file('file')->getRealPath())->getSecurePath();
        return response(['url' => $imageUrl, 'success'=>true]);
    }
}
