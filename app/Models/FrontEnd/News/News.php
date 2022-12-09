<?php

namespace App\Models\FrontEnd\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class News extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'news';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'alias',
        'category_id',
    ];

    /**
     * @param $category_id
     *
     * @return Collection
     */
    public function getAllByCategoryId($category_id = null)
    {
        return DB::table($this->table)
            ->select('*')
            ->where('category_id', $category_id)
            ->whereNull('deleted_at')
            ->get();
    }

    /**
     * @param $alias
     *
     * @return mixed
     */
    public function getByAlias($alias)
    {
        return DB::table($this->table)
            ->select('*')
            ->where('alias', $alias)
            ->whereNull('deleted_at')
            ->get()->first();
    }
}
