<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'name', 'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function api_services()
    {
        return $this->belongsToMany(Api_service::class, 'accounts_api_services', 'account_id	', 'api_service_id');
    }
}
