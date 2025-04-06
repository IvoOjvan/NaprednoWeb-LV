<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dissertation extends Model
{
    //
    protected $fillable = ["title", 'eng_title', "description", "course", "students"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
