<?php

namespace App\Domain\User;

/**
 * Interface Languages
 */
interface Languages
{
    /**
     * @param Language $language
     */
    public function add(Language $language): void;

    /**
     * @param string $name
     *
     * @return Language|null
     */
    public function findByName(string $name): ?Language;
}
