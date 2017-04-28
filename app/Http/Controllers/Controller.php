<?php

namespace App\Http\Controllers;

use App\Eloquent\Model;
use App\Eloquent\Collection;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected static function isAssoc($arr)
    {
        $len = count($arr);
        $keys = array_keys($arr);
        for ($i = 0; $i < $len; $i++) {
            if ($i !== $key[$i]) {
                return true;
            }
        }

        return false;
    }

    protected function json_or_dd($data, $only_data = true)
    {
        if ($data instanceof Collection) {
            $array = $data->toArray();
        } elseif ($data instanceof Model) {
            $array = $data->toArray();
        } else {
            $array = $data;
        }
        if (\Request::wantsJson() || !env('APP_DEBUG', false)) {
            die(json_encode($array));
        }
        if ($only_data) {
            dd($array);
        }
        dd($data);
    }
}
