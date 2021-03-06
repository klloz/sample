<?php

namespace App\Application\User\Query\LangList;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class LangListView
 */
class LangListView
{
    /**
     * @Serializer\Type("integer")
     *
     * @var int
     */
    public $totalCount;

    /**
     * @Serializer\Type("array<App\Application\User\Query\LangList\LangView>")
     *
     * @var LangView[]
     */
    public $data;

    /**
     * LangListView constructor.
     *
     * @param LangView[]|null $data
     */
    public function __construct(?array $data)
    {
        $this->data = $data;
        $this->totalCount = count($this->data);
    }
}
