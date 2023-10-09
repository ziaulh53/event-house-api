<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function fetchServices(){
        $service = Service::with('user', 'category')->get();
        return response(['success'=>true, 'services'=>$service]);
    }
    public function createService(CreateServiceRequest $request){
        $user = Auth::user();
        $data = $request->validated();
        $data['user_id'] = $user->id;
        $data['images'] = json_encode($request['images']);
        Service::create($data);
        return response(['success'=>true, 'msg'=>'Your service is created']);
    }
}
