<?php

namespace Module\Infrastructure\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\System\Models\SystemUser As Model;

class InfrastructureUser extends Model
{
    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-user'];
}
