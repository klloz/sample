<?php

namespace App\Application\User\Query\UserList;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class LangListView
 */
class UserListView
{
    /**
     * @Serializer\Type("integer")
     *
     * @var int
     */
    public $totalCount;

    /**
     * @Serializer\Type("array<App\Application\User\Query\UserList\UserView>")
     *
     * @var UserView[]
     */
    public $data;

    /**
     * UserListView constructor.
     *
     * @param UserView[]|null $data
     */
    public function __construct(?array $data)
    {
        $this->data = $data;
        $this->totalCount = count($this->data);
    }
}
