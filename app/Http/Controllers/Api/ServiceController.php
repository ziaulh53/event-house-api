<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function fetchServices(){
        return Service::query()->orderBy('id', 'desc')
            ->paginate(10);
    }
    public function createService(CreateServiceRequest $request){
        $data = $request->validated();
        echo $data;
    }
}
