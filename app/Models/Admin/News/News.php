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
            'title'       => $params['title'],
            'description' => $params['description'],
            'content'     => $params['content'],
            'category_id' => $params['category_id'],
            'status'      => !empty($params['status']) ? $params['status'] : Constant::NUMBER_ZERO,
            'active'      => !empty($params['active']) ? $params['active'] : Constant::NUMBER_ZERO,
            'del_flg'     => Constant::NUMBER_ZERO,
            'updated_at'  => $dateTime,
            'updated_by'  => $params['userId']
        ];
        if (empty($params['id'])) {
            $arrData['created_at'] = $dateTime;
            $arrData['created_by'] = $params['userId'];
            $insertOrUpdate = DB::table($this->table)->insertGetId($arrData);
        } else {
            DB::table($this->table)
                ->where('id', $params['id'])
                ->update($arrData);

            $insertOrUpdate = $params['id'];
        }

        return $insertOrUpdate;
    }

    /**
     * @param $params
     *
     * @return mixed
     */
    public function updatePathImageNews($params)
    {
        $dateTime = now();
        $arrData = [
            'image'      => $params['image'],
            'updated_at' => $dateTime,
            'updated_by' => $params['userId']
        ];

        DB::table($this->table)
            ->where('id', $params['id'])
            ->update($arrData);
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
