<?php

namespace InitSoftBot;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class App extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $slug = strtolower($name);
        $this->attributes['slug'] = str_slug($slug, '-');
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
