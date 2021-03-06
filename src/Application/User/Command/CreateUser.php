<?php

namespace App\Application\User\Command;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CreateUser
 */
class CreateUser
{
    /**
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    public $uuid;

    /**
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    public $name;

    /**
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    public $surname;

    /**
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     * @Assert\Email()
     *
     * @var string
     */
    public $email;

    /**
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     * @Assert\Regex("/^\d{11}$/", message="PESEL must be exactly 11 digits.")
     *
     * @var string
     */
    public $pesel;

    /**
     * @Serializer\Type("string")
     *
     * @var string
     */
    public $langs;

    /**
     * CreateUser constructor.
     *
     * @param string|null $uuid
     * @param string|null $name
     * @param string|null $surname
     * @param string|null $email
     * @param string|null $pesel
     * @param string|null $langs
     */
    public function __construct(
        string $uuid = null,
        string $name = null,
        string $surname = null,
        string $email = null,
        string $pesel = null,
        string $langs = null
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->pesel = $pesel;
        $this->langs = $langs;
    }
}
