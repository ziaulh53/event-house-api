<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateServiceRequest;
use App\Http\Requests\UpdateMyServiceRequest;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function fetchServices()
    {
        $service = Service::with('user', 'category')->get();
        return response(['success' => true, 'services' => $service]);
    }
    public function createService(CreateServiceRequest $request)
    {
        try {
            $user = Auth::user();
            $data = $request->validated();
            $data['user_id'] = $user->id;
            $data['images'] = json_encode($request['images']);
            Service::create($data);
            return response(['success' => true, 'msg' => 'Your service is created']);
        } catch (Exception $e) {
            return response(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function getUserService()
    {
        $user = Auth::user();
        $service = Service::where('user_id', '=', $user->id)->with(['user', 'category'])->get();
        return response(['success' => true, 'service' => $service]);
    }

    public function deleteMyService(Request $request)
    {
        try {
            $user = Auth::user();
            $service = Service::query()->find($request['id']);
            if ($service['user_id'] == $user->id) {
                $service->delete();
            } else {
                return response(['success' => false, 'msg' => 'You are not allowed to DELETE!']);
            }
            return response(['success' => true, 'msg' => 'Delete successfully']);
        } catch (Exception $e) {
            return response(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    public function updateMyService(UpdateMyServiceRequest $request)
    {
        try {
            $user = Auth::user();
            $service = Service::query()->find($request['id']);
            if (!$service) {
                return response(['success' => false, 'msg' => 'This service is not exist!']);
            }
            $data = $request->validated();
            if ($service['user_id'] == $user->id) {
                $service->update($data);
            } else {
                return response(['success' => false, 'msg' => 'You are not allowed to UPDATE!']);
            }
            return response(['success' => true, 'msg' => 'Update successfully']);
        } catch (Exception $e) {
            return response(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}
