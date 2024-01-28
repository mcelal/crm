<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Stancl\Tenancy\Database\Models\Domain as StanclDomain;

class Domain extends StanclDomain
{
    use HasFactory;
}
