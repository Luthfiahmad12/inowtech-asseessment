<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $guarded = ['id'];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function scopeSearch(Builder $query, $request): void
    {
        $query->whereAny(['name', 'email', 'teacher_id'], 'like', '%' . $request . '%');
    }
}
