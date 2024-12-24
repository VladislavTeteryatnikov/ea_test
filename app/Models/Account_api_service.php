<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account_api_service extends Model
{
    protected $table = 'accounts_api_services';

    protected $fillable = [
        'account_id', 'api_service_id', 'token_id', 'token_access'
    ];
}
