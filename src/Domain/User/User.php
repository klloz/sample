<?php

namespace App\Domain\User;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 *
 * Class User
 */
class User
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
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $surname;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=11)
     */
    private $pesel;

    /**
     * @var DateTime
     * @ORM\Column(type="date")
     */
    private $birthDate;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $registrationDate;

    /**
     * @var Language[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="Language", inversedBy="users", cascade={"persist"})
     * @ORM\JoinTable(name="user_lang",
     *      joinColumns={@ORM\JoinColumn(name="user_uuid", referencedColumnName="uuid")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="lang_uuid", referencedColumnName="uuid")}
     *      )
     */
    private $langs;

    /**
     * User constructor.
     *
     * @param string $uuid
     * @param string $name
     * @param string $surname
     * @param string $email
     * @param string $pesel
     * @param DateTime $birthDate
     */
    public function __construct(string $uuid, string $name, string $surname, string $email, string $pesel, DateTime $birthDate)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->pesel = $pesel;
        $this->langs = new ArrayCollection();
        $this->birthDate = $birthDate;
        $this->registrationDate = new DateTime();
    }

    /**
     * @param Language $lang
     */
    public function addLang(Language $lang)
    {
        $this->langs->add($lang);
    }
}
