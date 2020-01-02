<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloggerViewSummary extends Model
{
    protected $primaryKey = 'id_user';
    protected $table = 'blogger_view_summary';
    public $timestamps = false;
}
