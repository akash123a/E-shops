<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Navbar extends Model
{
    protected $fillable = ['title', 'url', 'order', 'status', 'parent_id'];

    // Parent
    public function parent()
    {
        return $this->belongsTo(Navbar::class, 'parent_id');
    }

    // Children
    public function children()
    {
        return $this->hasMany(Navbar::class, 'parent_id')->orderBy('order');
    }

    public function page()
{
    return $this->belongsTo(\App\Models\Page::class);
}
}