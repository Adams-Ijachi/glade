<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/** @mixin \App\Models\Company */
class CompanyResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo' => $this->logo,
            'website' => $this->website,

            'createdBy' => $this->createdBy,
            'company_account' => $this->when(Auth::user()->hasDirectPermission('get employee'), $this->user),
            'employees' => $this->when(Auth::user()->hasDirectPermission('get employee'), $this->employees),

        ];
    }
}
