<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Resources\AdminResource;
use App\Http\Traits\ResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use ResponseTrait;
    public function __construct()
    {
        $this->middleware('role:super-admin');

    }

    public function index()
    {
        return AdminResource::collection(User::role('admin')->paginate(10));
    }

    public function store(CreateAdminRequest $request)
    {
        try {

            $admin = User::create($request->validated());
            $admin->assignRole('admin');

            return AdminResource::make($admin)->additional([
                'message' => 'Admin Created'
            ])->response()->setStatusCode(201);

        } catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }
    }

    public function update(UpdateAdminRequest $request, User $admin)
    {
        try {

            if (!$admin->hasRole('admin')) {
                return $this->failed('Admin not found');
            }

            $admin->update($request->validated());

            return AdminResource::make($admin)->additional([
                'message' => 'Admin Updated'
            ])->response()->setStatusCode(201);

        } catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }
    }


    public function destroy(User $admin)
    {
        try {
            if (!$admin->hasRole('admin')) {
                return $this->failed('Admin not found');
            }
            $admin->delete();
            return $this->success('Admin Deleted');
        } catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }
    }

}
