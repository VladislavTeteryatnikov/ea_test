<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Api_service extends Model
{
    protected $fillable = [
        'name', 'url',
    ];

    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'accounts_api_services', 'api_service_id', 'account_id');
    }
}
