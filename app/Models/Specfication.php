<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;


class Specfication extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
        'status'
    ];
    public function doctors(){
        return $this->hasMany(Doctor::class);
    }
    
}
