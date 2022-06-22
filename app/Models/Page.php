<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';
	
	public function content()
    {
        return $this->hasMany('App\Models\PageContent');
    }
	
	public function author()
    {
        return $this->hasOne('App\Models\User', 'id', 'author_id');
    }

}