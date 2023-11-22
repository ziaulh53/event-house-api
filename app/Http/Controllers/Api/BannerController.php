<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function fetchBanners()
    {
        $getBanners =  Banner::query()->first();
        $banners = [];
        if($getBanners){
            $banners = json_decode($getBanners['banners']);
        }
        return response(['success' => true, 'banners' => $banners]);
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
