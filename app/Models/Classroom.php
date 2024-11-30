<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $guarded = ['id'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function scopeSearch(Builder $query, $request): void
    {
        $query->where('class_name', 'like', '%' . $request . '%');
    }
}
