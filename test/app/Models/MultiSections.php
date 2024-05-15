<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiSections extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sections() {

        return $this->belongsTo(User::class, 'user_id', 'id');

    }

}
