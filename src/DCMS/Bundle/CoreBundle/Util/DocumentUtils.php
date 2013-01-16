<?php

namespace DCMS\Bundle\CoreBundle\Util;

/**
 * Class providing miscilaneous reuseable code
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class DocumentUtils
{
    public static function slugify($string)
    {
        setlocale(LC_CTYPE, 'fr_FR.UTF8');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $clean = strip_tags($clean);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);

        if (substr($clean, -1) == '-') {
            $clean = substr($clean, 0, -1);
        }

        return $clean;
    }
}

?>
