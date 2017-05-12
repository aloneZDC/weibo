<?php

namespace App\Helpers;

/*
 * Antvel - Products Helper
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

class ProductsHelper
{
    public static function level($categories, $category_id)
    {
        $cont = 0;
        foreach ($categories as $value) {
            if ($value['id'] == $category_id) {
                return 1 + self::level($categories, $value['category_id']);
            }
        }

        return 0;
    }

    public static function categoriesDropDownFormat($array, &$outPut)
    {
        foreach ($array as $row) {

            /**
             * $level
             * Contains the category tree.
             *
             * @var [type]
             */
            $level = static::level($array, $row['category_id']);

            $s = '';
            for ($i = 0; $i < $level; $i++) {
                $s .= '&nbsp;&nbsp;&nbsp;';
            }

            $icon = 2;
            if ($level % 3 == 0) {
                $icon = 0;
            } elseif ($level % 2 == 0) {
                $icon = 1;
            }

            $indentation = ['&#9679;', '&#8226;', '&ordm;'][$icon];
            $outPut[$row['id']] = $s.$indentation.'&nbsp;'.$row['name'];
        }
    }
}
