<?php

namespace App\Models\Admin\Permission;

use App\Common\Constant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Permission extends Model
{
    /**
     * @var string
     */
    protected $table = 'permissions';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'permission',
        'role_id',
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
        $sql = DB::table($this->table . ' as p');
        if ($where) {
            $sql->where($where);
        }
        if ($orderBy) {
            $sql->orderByRaw($orderBy);
        }
        $sql->join('users as u', function ($join) {
            $join->on('u.id', '=', 'p.updated_by')
                ->whereNull('u.deleted_at');
        });
        $sql->join('roles as r', function ($join) {
            $join->on('r.id', '=', 'p.role_id')
                ->whereNull('r.deleted_at');
        });

        return $sql->select(
            'p.*', 'r.name as role_name',
            DB::raw("CONCAT(u.last_name,' ',u.first_name) AS full_name"),
            Db::raw(
                'DATE_FORMAT(p.created_at, "' . Constant::FORMAT_YEAR_MONTH_DAY_MIN . '") as created_at'
            ),
            Db::raw(
                'DATE_FORMAT(p.updated_at, "' . Constant::FORMAT_YEAR_MONTH_DAY_MIN . '") as updated_at'
            ))
            ->whereNull('p.deleted_at')
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
            'permission' => $params['permission'],
            'role_id'    => $params['role_id'],
            'active'     => $params['active'] ?? Constant::NUMBER_ZERO,
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
    public function deletePermission($params)
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
     * @return Collection
     */
    public function getAllByRoleId($id)
    {
        $sql = DB::table($this->table . ' as p')
            ->join('roles as r', function ($join) use ($id) {
                $join->on('r.id', '=', 'p.role_id')
                    ->whereNull('r.deleted_at')
                    ->where('r.id', $id);
            });

        return $sql->select('p.permission')
            ->whereNull('p.deleted_at')
            ->get();
    }
}
