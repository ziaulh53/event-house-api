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
        if (isset($request['banners'])) {
            $data['banners'] = json_encode($request['banners']);
            $banner->update($data);
            return response(['success' => true, 'msg' => 'Banner Updated']);
        } else {
            return response(['success' => false, 'msg' => 'Banners are not provided!']);
        }
    }
}
