<?php

namespace App\Application\User\Command;

use App\Application\User\PeselHelper;
use App\Domain\User\Language;
use App\Domain\User\Languages;
use App\Domain\User\User;
use App\Domain\User\Users;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Exception\LogicException;

/**
 * Class CreateUserHandler
 */
class CreateUserHandler
{
    /**
     * @var Users
     */
    private $users;

    /**
     * @var Languages
     */
    private $langs;

    /**
     * @var PeselHelper
     */
    private $peselHelper;

    /**
     * CreateUserHandler constructor.
     *
     * @param Users $users
     * @param Languages $langs
     * @param PeselHelper $peselHelper
     */
    public function __construct(Users $users, Languages $langs, PeselHelper $peselHelper)
    {
        $this->users = $users;
        $this->langs = $langs;
        $this->peselHelper = $peselHelper;
    }

    /**
     * @param CreateUser $command
     */
    public function handle(CreateUser $command): void
    {
        $email = $command->email;
        $pesel = $command->pesel;

        $this->peselHelper::validate($pesel);

        if ($this->users->findByEmail($email)) {
            throw new LogicException("The email '$email' is already in use.");
        }

        $user = new User(
            $command->uuid,
            $command->name,
            $command->surname,
            $email,
            $pesel,
            $this->peselHelper::retrieveDateOfBirth($pesel)
        );

        $userLangNames = explode(',', $command->langs);

        foreach ($userLangNames as $userLangName) {
            $userLang = $this->langs->findByName(trim($userLangName));

            if (!$userLang) {
                $userLang = new Language(
                    Uuid::uuid4()->toString(),
                    trim($userLangName)
                );
            }

            $user->addLang($userLang);
        }

        $this->users->add($user);
    }
}
