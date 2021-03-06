<?php

namespace App\Application\User\Query\UserList;

use DateTime;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class LangView
 */
class UserView
{
    /**
     * @Serializer\Type("string")
     *
     * @var string
     */
    public $uuid;

    /**
     * @Serializer\Type("string")
     *
     * @var string
     */
    public $name;

    /**
     * @Serializer\Type("string")
     *
     * @var string
     */
    public $surname;

    /**
     * @Serializer\Type("string")
     *
     * @var string
     */
    public $email;

    /**
     * @Serializer\Type("string")
     *
     * @var string
     */
    public $langs;

    /**
     * @Serializer\Type("DateTime<'Y-m-d'>")
     *
     * @var DateTime
     */
    public $registrationDate;

    /**
     * @Serializer\Type("integer")
     *
     * @var int
     */
    public $age;

    /**
     * @Serializer\Type("string")
     *
     * @var string
     */
    public $timeToFullAge;

    /**
     * LangView constructor.
     *
     * @param string $uuid
     * @param string|null $name
     * @param string|null $surname
     * @param string|null $email
     * @param string|null $langs
     * @param DateTime|null $birthDate
     * @param DateTime|null $registrationDate
     */
    public function __construct(
        string $uuid,
        string $name = null,
        string $surname = null,
        string $email = null,
        string $langs = null,
        DateTime $birthDate = null,
        DateTime $registrationDate = null
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->langs = $langs;
        $this->registrationDate = $registrationDate;

        $this->age = $this->calculateAge($birthDate);
        $this->timeToFullAge = $this->calculateTimeToFullAge($birthDate);
    }

    /**
     * @param DateTime $birthDate
     *
     * @return int
     */
    private function calculateAge(DateTime $birthDate): int
    {
        return (new DateTime())->diff($birthDate)->y;
    }

    /**
     * @param DateTime $birthDate
     *
     * @return string
     */
    private function calculateTimeToFullAge(DateTime $birthDate): string
    {
        $currentDate = new DateTime();
        # Date of 18th birthday
        $fullAgeDate = $birthDate->modify('+18 year');

        $yearsToFullAge = $fullAgeDate->diff($currentDate)->y;
        # Current date + number of years until 18th birthday
        $comparisonDate = $currentDate->modify("+$yearsToFullAge year");

        $daysToFullAge = $fullAgeDate->diff($comparisonDate)->format('%a');

        return $yearsToFullAge . 'y ' . $daysToFullAge . 'd';
    }
}
