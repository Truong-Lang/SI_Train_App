<?php

namespace App\Models\FrontEnd\News;

use Illuminate\Database\Eloquent\Model;
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
     * @param null $where
     * @param bool $first
     *
     * @return mixed
     */
    public function getAll($where = null, bool $first = false)
    {
        $sql = DB::table($this->table . ' as n')
            ->join('categories as c', function ($join) {
                $join->on('n.category_id', '=', 'c.id')
                    ->whereNull('c.deleted_at');
            })
            ->select('*', 'n.alias AS news_alias');
        if ($where) {
            $sql->where($where);
        }

        $sql->whereNull('n.deleted_at');

        if ($first) {
            return $sql->get()->first();
        } else {
            return $sql->get();
        }
    }
}
