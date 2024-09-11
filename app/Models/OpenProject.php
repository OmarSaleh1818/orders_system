<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenProject extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function project() {

        return $this->belongsTo(projects::class, 'project_id', 'id');

    }

    public function projectStart() {

        return $this->belongsTo(IndirectCosts::class, 'project_id', 'project_id');

    }

}
