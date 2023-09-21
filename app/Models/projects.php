<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projects extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function multiProjects()
    {
        return $this->hasMany(MultiProject::class);
    }

    public function projects() {

        return $this->belongsTo(User::class, 'user_id', 'id');

    }


}
