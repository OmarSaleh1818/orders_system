<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiProject extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function project() {

        return $this->belongsTo(projects::class, 'project_id', 'id');

    }

    public function step() {

        return $this->belongsTo(MultiStep::class, 'step_id', 'id');

    }

}
