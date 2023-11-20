<?php

namespace App\Services\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiModel extends Model
{
    use HasFactory, Tabulate, QueryRequest;
}
