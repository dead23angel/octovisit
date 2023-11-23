<?php

namespace CWTeam\OctoVisit\Models;

use October\Rain\Auth\Models\User as UserBase;

class User extends UserBase
{
    /**
     * @var string The database table used by the model.
     */
    protected $table = 'users';
}
