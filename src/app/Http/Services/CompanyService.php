<?php


namespace App\Http\Services;


use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CompanyService
{

    private User $companyAccount;
    /**
     * @throws \Exception
     */
    public function store($request): Company
    {
        try {

            $this->createCompanyAccount($request->safe()->only(['email', 'password','first_name','last_name']));

            return $this->createCompany($request->safe()->only(['name', 'website', 'logo']));
        } catch (\Exception $e) {
            throw $e;
        }
    }


    // store logo and return path
    private function storeLogo($logo)
    {

        return $logo->store('logo','public');
    }



    protected function createCompanyAccount($validated): void
    {
        try {
            $this->companyAccount = User::create($validated);
            $this->companyAccount->assignRole('company');
            return;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function createCompany($only): Company
    {
        try {

            if (array_key_exists('logo', $only)) {
                $only['logo'] = $this->storeLogo($only['logo']);
            }
            $only['user_id'] = $this->companyAccount->id;
            $only['created_by'] = Auth::id();


            return Company::create($only);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @throws \Exception
     */
    public function update($data, Company $company): Company
    {
        try {

            if($data['logo']){
                $data['logo'] = $this->storeLogo($data['logo']);
            }

            $company->update($data);

            return $company;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
