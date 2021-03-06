<?php

namespace App\Application\User\Query\LangList;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class LangView
 */
class LangView
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
     * @Serializer\Type("integer")
     *
     * @var int
     */
    public $userCount;

    /**
     * LangView constructor.
     *
     * @param string $uuid
     * @param string|null $name
     * @param int|null $userCount
     */
    public function __construct(
        string $uuid,
        string $name = null,
        int $userCount = null
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->userCount = $userCount;
    }
}
