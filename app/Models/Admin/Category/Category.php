<?php

namespace App\Models\Admin\Category;

use App\Common\Constant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

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
        'name',
        'parent',
        'status',
        'updated_at',
        'del_flg',
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
     * @param $id
     *
     * @return mixed
     */
    public function getById($id)
    : mixed {
        return DB::table($this->table)
            ->select('*')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->get()->first();
    }

    /**
     * @param $params
     *
     * @return int
     */
    public function insertOrUpdate($params)
    : int {
        $dateTime = now();
        $arrData = [
            'name'       => $params['name'],
            'alias'      => $params['alias'],
            'parent'     => !empty($params['parent']) ? $params['parent'] : Constant::NUMBER_ZERO,
            'status'     => !empty($params['status']) ? $params['status'] : Constant::NUMBER_ZERO,
            'active'     => !empty($params['active']) ? $params['active'] : Constant::NUMBER_ZERO,
            'del_flg'    => Constant::NUMBER_ZERO,
            'updated_at' => $dateTime,
            'updated_by' => $params['userId']
        ];
        if (empty($params['id'])) {
            $arrData['created_at'] = $dateTime;
            $arrData['created_by'] = $params['userId'];
            $insertOrUpdate = DB::table($this->table)->insertGetId($arrData);
        } else {
            $insertOrUpdate = DB::table($this->table)
                ->where('id', $params['id'])
                ->update($arrData);
        }

        return $insertOrUpdate;
    }

    /**
     * @param $params
     *
     * @return int
     */
    public function deleteCategory($params)
    : int {
       return DB::table($this->table)
                ->where('id', $params['id'])
                ->update([
                    'deleted_at' => now(),
                    'deleted_by' => $params['userId'],
                ]);

    }

    public function getByAlias($alias)
    {
        return DB::table($this->table)
            ->select('*')
            ->where('alias', 'like', $alias)
            ->whereNull('deleted_at')
            ->get()->first();
    }
}
