<?php

namespace App\Models\FrontEnd\Category;

use App\Common\Constant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

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
    ];

    /**
     * @param $where
     * @param $orderBy
     *
     * @return array
     */
    public function getAll($where = null, $orderBy = null)
    : array {
        $sql = DB::table($this->table . ' as c');
        if ($where) {
            $sql->where($where);
        }
        if ($orderBy) {
            $sql->orderByRaw($orderBy);
        }
        $sql->join('users as u', function ($join) {
            $join->on('u.id', '=', 'c.updated_by')
                ->whereNull('u.deleted_at');
        });

        return $sql->select(
            'c.*',
            DB::raw("CONCAT(u.last_name,' ',u.first_name) AS full_name"),
            Db::raw(
                'DATE_FORMAT(c.created_at, "' . Constant::FORMAT_YEAR_MONTH_DAY_MIN . '") as created_at'
            ),
            Db::raw(
                'DATE_FORMAT(c.updated_at, "' . Constant::FORMAT_YEAR_MONTH_DAY_MIN . '") as updated_at'
            ))
            ->whereNull('c.deleted_at')
            ->get()->toArray();
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
