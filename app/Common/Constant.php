<?php

namespace App\Common;

class Constant
{
    /**
     * Define http status codes
     */
    const HTTP_STATUS_CODE_200 = 200;
    const HTTP_STATUS_CODE_400 = 400;
    const HTTP_STATUS_CODE_401 = 401;
    const HTTP_STATUS_CODE_403 = 403;
    const HTTP_STATUS_CODE_404 = 404;
    const HTTP_STATUS_CODE_422 = 422;
    const HTTP_STATUS_CODE_500 = 500;

    /**
     * Define folder name
     */
    const FOLDER_URL_ADMIN_ROUTE = 'admin';
    const FOLDER_URL_ADMIN       = 'Admin';
    const FOLDER_URL_FRONTEND    = 'FrontEnd';

    /**
     * Define number
     */
    const NUMBER_ZERO = 0;
    const NUMBER_ONE  = 1;

    /**
     * Define format date
     */
    const FORMAT_DATE_TMP           = 'Y/m/d';
    const FORMAT_YEAR_MONTH_DAY_MIN = '%Y/%m/%d %H:%i';

    /**
     * Folder name file upload
     */
    const NEWS_IMAGES_FOLDER = 'news';

    /**
     * Default page rows
     */
    const ROWS_PER_PAGE = 5;

    /**
     * Define role
     */
    const ROLE_ADMIN = 'Admin';
    const ROLE_USER  = 'User';

    /**
     * Define Gate name
     */
    const GATE_ROLE_IS_ADMIN   = 'isAdmin';
    const GATE_ROLE_IS_USER    = 'isUser';
    const GATE_UPDATE_NEWS     = 'edit-news';
    const GATE_DELETE_NEWS     = 'delete-news';
    const GATE_UPDATE_CATEGORY = 'edit-category';
    const GATE_DELETE_CATEGORY = 'delete-category';

    /**
     * Define permission
     */
    const PERMISSION_UPDATE_NEWS     = 'Update News';
    const PERMISSION_DELETE_NEWS     = 'Delete News';
    const PERMISSION_UPDATE_CATEGORY = 'Update Category';
    const PERMISSION_DELETE_CATEGORY = 'Delete Category';
}