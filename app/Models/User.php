<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Common\Constant;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @param $where
     * @param $orderBy
     *
     * @return LengthAwarePaginator
     */
    public function getAll($where = null, $orderBy = null)
    : LengthAwarePaginator {
        $sql = DB::table($this->table . ' as u');
        if ($where) {
            $sql->where($where);
        }
        if ($orderBy) {
            $sql->orderByRaw($orderBy);
        }
        $sql->join('users as author', function ($join) {
            $join->on('author.id', '=', 'u.updated_by')
                ->whereNull('author.deleted_at');
        });
        $sql->join('roles as r', function ($join) {
            $join->on('r.id', '=', 'u.role_id')
                ->whereNull('r.deleted_at');
        });

        return $sql->select(
            'u.*', 'r.name as role_name',
            DB::raw("CONCAT(author.last_name,' ',author.first_name) AS full_name"),
            Db::raw(
                'DATE_FORMAT(u.created_at, "' . Constant::FORMAT_YEAR_MONTH_DAY_MIN . '") as created_at'
            ),
            Db::raw(
                'DATE_FORMAT(u.updated_at, "' . Constant::FORMAT_YEAR_MONTH_DAY_MIN . '") as updated_at'
            ))
            ->whereNull('u.deleted_at')
            ->paginate(Constant::ROWS_PER_PAGE);
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
    public function updateUser($params)
    : int {
        $dateTime = now();
        $arrData = [
            'role_id'    => $params['role_id'],
            'del_flg'    => Constant::NUMBER_ZERO,
            'updated_at' => $dateTime,
            'updated_by' => $params['userId']
        ];

        return DB::table($this->table)
            ->where('id', $params['id'])
            ->update($arrData);
    }
}
