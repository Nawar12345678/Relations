<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Specfication;
use App\Models\Hospital;
use App\Http\Controllers\SpcficationController;



class Doctor extends Model
{
    use HasFactory;
    protected $fillable=[
        'first_name',
        'last_name' ,
        'specialest',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . '' . $this->last_name;
    }

    public function setFirstNameAttribute($value)
{
    $this->attributes['first_name'] = Ucfirst($value);
}

public function specfication(){
    return $this->belongsTo(Specfication::class);
}

public function hospitals(){
    return $this->belongsToMany(Hospital::class);
}


}
