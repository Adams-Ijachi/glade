<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Services\AuthService;
use App\Http\Services\CompanyService;
use App\Http\Traits\ResponseTrait;
use App\Mail\CompanyCreated;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CompanyController extends Controller
{
    use ResponseTrait;

    private CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
        $this->middleware('role_or_permission:create company', ['only' => ['store']]);
        $this->middleware('role:super-admin', ['only' => ['index']]);
        $this->middleware('role_or_permission:update company', ['only' => ['update']]);
        $this->middleware('role_or_permission:delete company', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:get company', ['only' => ['getCompany']]);
    }



    public function index()
    {
        return CompanyResource::collection(Company::all());
    }

    public function store(CreateCompanyRequest $request)
    {

        try{
            $company =  $this->companyService->store($request);

            Mail::to($request->user())->send(new CompanyCreated($company));

            return CompanyResource::make($company)->additional([
               'message' => 'Company Created'
            ])->response()->setStatusCode(201);

        }catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }
    }

    public function show($id)
    {

    }

    public function update(UpdateCompanyRequest $request,Company $company)
    {
        try{
            $company = $this->companyService->update($request->validated(),$company);

            return CompanyResource::make($company)->additional([
                'message' => 'Company Created'
            ])->response()->setStatusCode(201);

        }catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }
    }



    public function getCompany()
    {
        return CompanyResource::make(Auth::user()->employee->company);
    }


    public function destroy(Company $company)
    {
        try{
            $company->delete();
            return $this->success('Company deleted successfully', [], 200);
        }catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }
    }

}
