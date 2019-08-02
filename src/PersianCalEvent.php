<?php namespace hpez\PersianCalEvent;

use Carbon\Carbon;
use Morilog\Jalali\CalendarUtils;

/**
*
*  @author Hassan Pezeshk
*/
class PersianCalEvent
{

    /**
     * @param int $y
     * @param int $m
     * @param int $d
     * @return \stdClass
     */
    private static function crawl($y, $m, $d, $type)
    {
        $handle = curl_init();

        $url = "https://persiancalapi.ir/$type/$y/$m/$d";

        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_FAILONERROR, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

        $output = curl_exec($handle);

        if (curl_errno($handle)) {
            print curl_error($handle);
        }

        curl_close($handle);

        $output = json_decode($output);

        return $output;
    }

    /**
     * @param int $y
     * @param int $m
     * @param int $d
     * @return \stdClass
     */
    public static function jalali($y, $m, $d)
    {
        return self::crawl($y, $m ,$d, 'jalali');
    }

    /**
     * @param int|Carbon $y
     * @param int|null $m
     * @param int|null $d
     * @return \stdClass
     */
    public static function gregorian($y, $m = null, $d = null)
    {
        if ($m == null) {
            $m = $y->month;
            $d = $y->day;
            $y = $y->year;
        }

        return self::crawl($y, $m, $d, 'gregorian');
    }
}