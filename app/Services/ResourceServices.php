<?php

namespace App\Services;

use App\Models\Resource;

class ResourceServices
{
    public static function list($params)
    {
        return Resource::where(static function ($query) use ($params)  {
            if (!empty($params['fileName'])) {
                $query->where('fileName', 'like', sprintf('%%%s%%', $params['fileName']));
            }
            if (!empty($params['fileType'])) {
                $query->where('fileType', 'like', sprintf('%%%s%%', $params['fileType']));
            }

        })->orderByDesc('id');
    }
}