<?php

namespace App\Domain\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lang")
 *
 * Class Language
 */
class Language
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string", length=36, unique=true)
     */
    private $uuid;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $name;

    /**
     * @var User[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="User", mappedBy="langs")
     */
    private $users;

    /**
     * Language constructor.
     *
     * @param string $uuid
     * @param string $name
     */
    public function __construct(string $uuid, string $name)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->users = new ArrayCollection();
    }
}
