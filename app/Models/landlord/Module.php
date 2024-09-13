<?php

namespace App\Models\landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ["icon", "name", "description", "order"];
}
