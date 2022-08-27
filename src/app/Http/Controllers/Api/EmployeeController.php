<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Services\EmployeeService;
use App\Http\Traits\ResponseTrait;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    use ResponseTrait;

    private EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
        $this->middleware('role_or_permission:create employee', ['only' => ['store']]);
        $this->middleware('role:super-admin|company', ['only' => ['index']]);
        $this->middleware('role_or_permission:update employee', ['only' => ['update']]);
        $this->middleware('role_or_permission:delete employee', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:get employee', ['only' => ['getCompanyEmployees']]);
    }


    public function index()
    {

        return EmployeeResource::collection(Employee::with('company','user')->paginate(10));

    }

    // get company employees
    public function getCompanyEmployees()
    {
        try {

            return EmployeeResource::collection(Auth::user()->company->employees->load('user'))->additional([
                'message' => 'Employees Found'
            ])->response()->setStatusCode(200);

        } catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }
    }

    public function store(CreateEmployeeRequest $request)
    {
        try{
            $employee = $this->employeeService->store($request);
            return EmployeeResource::make($employee->load('user','company'))->additional([
                'message' => 'Employee Created'
            ])->response()->setStatusCode(201);
        }catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }
    }

    public function show($id)
    {
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        try{
            $employee = $this->employeeService->update($request, $employee);
            return EmployeeResource::make($employee->load('user','company'))->additional([
                'message' => 'Employee Updated'
            ])->response()->setStatusCode(201);
        }catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }
    }

    public function destroy(Employee $employee)
    {
        try{

            $employee = $this->employeeService->destroy($employee);
            return $this->success('Employee Deleted');
        }catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }
    }

}
