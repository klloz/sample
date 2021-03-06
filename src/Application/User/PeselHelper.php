<?php

namespace App\Application\User;

use DateTime;
use InvalidArgumentException;

/**
 * Class PeselHelper
 */
class PeselHelper
{
    /**
     * https://en.wikipedia.org/wiki/PESEL#Birthdates
     * @param $pesel
     *
     * @return DateTime
     */
    public static function retrieveDateOfBirth($pesel): DateTime
    {
        $yearTwoLastDigits = (int)substr($pesel, 0, 2);
        $rawMonth = substr($pesel, 2, 2);
        $day = substr($pesel, 4, 2);

        switch (intval($rawMonth / 20)) {
            case 0:
                $year = 1900 + $yearTwoLastDigits;
                break;
            case 1:
                $year = 2000 + $yearTwoLastDigits;
                break;
            case 2:
                $year = 2100 + $yearTwoLastDigits;
                break;
            case 3:
                $year = 2200 + $yearTwoLastDigits;
                break;
            case 4:
                $year = 1800 + $yearTwoLastDigits;
                break;
            default:
                throw new InvalidArgumentException("The date of birth retrieved from PESEL is invalid.");
        }

        $dateString = implode('-', [$year, $rawMonth % 20, $day]);

        return DateTime::createFromFormat("Y-n-d", $dateString);
    }

    /**
     * https://en.wikipedia.org/wiki/PESEL#Checksum_calculation
     * @param string $pesel
     */
    public static function validate(string $pesel): void
    {
        $weightArray = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];
        $controlSum = 0;

        for ($digitIndex = 0; $digitIndex < 10; ++$digitIndex) {
            $controlSum += $weightArray[$digitIndex] * $pesel[$digitIndex];
        }

        $controlSum = 10 - $controlSum % 10;
        $controlSum = ($controlSum === 10) ? 0 : $controlSum;

        if ($controlSum !== (int)$pesel[10]) {
            throw new InvalidArgumentException("Invalid PESEL checksum.");
        }
    }
}
