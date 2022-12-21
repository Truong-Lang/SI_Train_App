<?php

namespace App\Models\Admin\Role;

use App\Common\Constant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    /**
     * @var string
     */
    protected $table = 'roles';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'del_flg',
    ];

    /**
     * @param $where
     * @param $orderBy
     *
     * @return array
     */
    public function getAll($where = null, $orderBy = null)
    {
        $sql = DB::table($this->table . ' as r');
        if ($where) {
            $sql->where($where);
        }
        if ($orderBy) {
            $sql->orderByRaw($orderBy);
        }
        $sql->join('users as u', function ($join) {
            $join->on('u.id', '=', 'r.updated_by')
                ->whereNull('u.deleted_at');
        });

        return $sql->select(
            'r.*',
            DB::raw("CONCAT(u.last_name,' ',u.first_name) AS full_name"),
            DB::raw(
                'DATE_FORMAT(r.created_at, "' . Constant::FORMAT_YEAR_MONTH_DAY_MIN . '") as created_at'
            ),
            DB::raw(
                'DATE_FORMAT(r.updated_at, "' . Constant::FORMAT_YEAR_MONTH_DAY_MIN . '") as updated_at'
            ))
            ->whereNull('r.deleted_at')
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
    public function deleteRole($params)
    : int {
        return DB::table($this->table)
            ->where('id', $params['id'])
            ->update([
                'del_flg'    => 1,
                'deleted_at' => now(),
                'deleted_by' => $params['userId'],
            ]);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getByUserId($id)
    {
        $sql = DB::table($this->table . ' as r')
            ->join('users as u', function ($join) use ($id) {
                $join->on('u.role_id', '=', 'r.id')
                    ->whereNull('u.deleted_at')
                    ->where('u.id', $id);
            });

        return $sql->select('r.name')
            ->whereNull('r.deleted_at')
            ->get()->first();
    }
}
