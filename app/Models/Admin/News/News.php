<?php

namespace App\Models\Admin\News;

use App\Common\Constant;
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
        'title',
        'description',
        'content',
        'image',
        'category_id',
        'del_flg',
    ];

    /**
     * @param $limit
     * @param $where
     * @param $orderBy
     * 
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getListNews($limit, $where = null, $orderBy = null)
    {
        $sql = DB::table($this->table . ' as n');
        if ($where) {
            $sql->where($where);
        }
        if ($orderBy) {
            $sql->orderByRaw($orderBy);
        }
        $sql->join('users as u', function ($join) {
            $join->on('u.id', '=', 'n.updated_by')
                ->whereNull('u.deleted_at');
        });
        $sql->join('categories as c', function ($join) {
            $join->on('n.category_id', '=', 'c.id')
                ->whereNull('c.deleted_at');
        });
        
        return $sql->select(
            'n.*', 'c.name as category_name',
            DB::raw("CONCAT(u.last_name,' ',u.first_name) AS full_name"),
            DB::raw(
                'DATE_FORMAT(n.created_at, "' . Constant::FORMAT_YEAR_MONTH_DAY_MIN . '") as created_at'
            ),
            DB::raw(
                'DATE_FORMAT(n.updated_at, "' . Constant::FORMAT_YEAR_MONTH_DAY_MIN . '") as updated_at'
            ))
            ->whereNull('n.deleted_at')
            ->paginate($limit);
    }

    /**
     * @param $params
     *
     * @return int
     */
    public function deleteNews($params)
    : int {
        return DB::table($this->table)
            ->where('id', $params['id'])
            ->update([
                'del_flg'    => 1,
                'deleted_at' => now(),
                'deleted_by' => $params['userId'],
            ]);
    }
}