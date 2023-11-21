<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function fetchBanners()
    {
        $banners =  Banner::query()->first();
        return response(['success' => true, 'banners' => json_decode($banners->banners)]);
    }
    public function createBanner(Request $request)
    {
        $banner = Banner::find(1); 
        $data['banners'] = json_encode($request['banners']);
        if(!$banner){
            Banner::create($data);
            return response(['success'=>true, 'msg'=>'Updated']);
        }
        $banner->update($data);
        return response(['success'=>true,  'msg'=>'Updated']);
    }
}
