<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    
    protected $fillable = [
        'first_name','last_name',"isMale","birth_date"
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
