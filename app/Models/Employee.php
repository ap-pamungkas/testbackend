<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'employes';
    protected $primaryKey = 'employee_id';

    protected $fillable = [
        'name',
        'image',
        'position',
        'phone',
        'division_id'

    ] ;



 function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'division_id');
    }

}
