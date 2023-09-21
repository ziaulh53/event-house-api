<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Resources\AdminResource;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Admin::where('role', '!=', 'super_admin')
            ->where('id', '!=', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $data['role'] = 'admin';
        $data['avatar'] = $request['avatar'];
        Admin::create($data);
        return response(['success'=>true, 'msg'=>'New Admin added'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        return response(['admin' => new AdminResource($admin), 'success' => true], 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $data = $request->validated();
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $admin->update($data);

        return response(['msg' => 'Admin updated', 'success' => true], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return response(['msg' => 'Deleted successfully', 'success' => true], 201);
    }
}
