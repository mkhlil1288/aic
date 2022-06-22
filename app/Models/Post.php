<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';
	
	public function content()
    {
        return $this->hasMany('App\Models\PostContent');
    }
	
	public function author()
    {
        return $this->hasOne('App\Models\User', 'id', 'author_id');
    }
	
	public function category()
    {
        return $this->hasOne('App\Models\PostCategory', 'id', 'category_id');
    }
}