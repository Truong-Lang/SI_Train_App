<?php

namespace App\Models\Admin\News;

use App\Common\Constant;
use App\Models\Admin\Category\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'menu_id',
        'category_id',
        'del_flg',
    ];

    /**
     * Get the Category of News.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @param $where
     * @param $orderBy
     *
     * @return array
     */
    public function getAll($where = null, $orderBy = null)
    : array {
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
        return $sql->select(
            'n.*',
            DB::raw("CONCAT(u.last_name,' ',u.first_name) AS full_name"),
            DB::raw(
                'DATE_FORMAT(n.created_at, "' . Constant::FORMAT_YEAR_MONTH_DAY_MIN . '") as created_at'
            ),
            DB::raw(
                'DATE_FORMAT(n.updated_at, "' . Constant::FORMAT_YEAR_MONTH_DAY_MIN . '") as updated_at'
            ))
            ->whereNull('n.deleted_at')
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
            'title'       => $params['title'],
            'description' => $params['description'],
            'content'     => $params['content'],
            'category_id' => $params['category_id'],
            'menu_id'     => $params['menu_id'],
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
            $insertOrUpdate = DB::table($this->table)
                ->where('id', $params['id'])
                ->update($arrData);
        }

        return $insertOrUpdate;
    }

    public function getCategory()
    {
    }
}
