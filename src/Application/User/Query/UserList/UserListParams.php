<?php

namespace App\Application\User\Query\UserList;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserListParams
 */
class UserListParams
{
    /**
     * @Serializer\Type("int")
     *
     * @var int
     */
    public $registeredSince;

    /**
     * @param Request $request
     *
     * @return UserListParams
     */
    public static function fromRequest(Request $request): self
    {
        $object = new self();
        $object->registeredSince = $request->get('registered_since');

        return $object;
    }
}
