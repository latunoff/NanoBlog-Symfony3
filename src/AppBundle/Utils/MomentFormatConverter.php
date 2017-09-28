<?php

namespace AppBundle\Utils;

class MomentFormatConverter
{
    /**
     * @var array
     */
    private static $formatConvertRules = array(
        'yyyy' => 'YYYY', 'yy' => 'YY', 'y' => 'YYYY',
        'dd' => 'DD', 'd' => 'D',
        'EE' => 'ddd', 'EEEEEE' => 'dd',
        'ZZZZZ' => 'Z', 'ZZZ' => 'ZZ',
        '\'T\'' => 'T',
    );

    /**
     * Returns associated moment.js format.
     *
     * @param string $format PHP Date format
     *
     * @return string
     */
    public function convert($format)
    {
        return strtr($format, self::$formatConvertRules);
    }
}
