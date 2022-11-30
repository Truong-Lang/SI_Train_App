<?php

namespace App\Utils;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class Paginate
{
    /**
     * @param $items
     * @param int $perPage
     * @param $page
     *
     * @return LengthAwarePaginator
     */
    public static function paginate($items, int $perPage = 5, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentPage = $page;
        $offset = ($currentPage * $perPage) - $perPage;
        $itemsToShow = array_slice($items, $offset, $perPage);

        return new LengthAwarePaginator($itemsToShow, $total, $perPage);
    }
}