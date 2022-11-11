<?php

namespace App\Common;

class RuleApp
{
    /**
     * @param $value
     *
     * @return string
     */
    public static function formatDate($value)
    : string {
        return date(Constant::FORMAT_DATE_TMP, strtotime($value));
    }
}