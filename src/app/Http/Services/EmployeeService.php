<?php


namespace App\Http\Services;

use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EmployeeService
{


    private User $employeeAccount;

    /**
     * @throws \Exception
     */
    public function store($request): Employee
    {
        try {

            $this->createEmployeeAccount($request->safe()->only(['email', 'password','first_name','last_name']));

            return $this->createEmployee($request->safe()->only(['phone','company_id']));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function createEmployeeAccount($only)
    {
        try {
            $this->employeeAccount = User::create($only);
            $this->employeeAccount->assignRole('employee');
            return;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function createEmployee($only): Employee
    {
        try {

            $only['user_id'] = $this->employeeAccount->id;
            // auth user is the company then assign company_id to employee
            $only['company_id'] = Auth::user()->hasRole('company') ? Auth::id() : $only['company_id'];
            return Employee::create($only);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function update($request, Employee $employee): Employee
    {
        try{
            $employee->user->update($request->safe()->only(['email', 'password','first_name','last_name']));
            $employee->update($request->safe()->only(['phone','company_id']));

            return $employee;

        }catch (\Exception $e) {
            throw $e;
        }
    }

    public function destroy(Employee $employee)
    {

        try{
            $employee->user->delete();
            $employee->delete();
            return $employee;
        }catch (\Exception $e) {
            throw $e;
        }
    }
}
