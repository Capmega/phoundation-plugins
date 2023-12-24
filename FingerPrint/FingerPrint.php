<?php

declare(strict_types=1);

namespace Plugins\FingerPrint;

use Phoundation\Accounts\Users\Interfaces\UserInterface;
use Phoundation\Data\DataEntry\DataEntry;
use Phoundation\Data\DataEntry\Definitions\Interfaces\DefinitionsInterface;
use Plugins\FingerPrint\Interfaces\FingerPrintsInterface;


/**
 * Class FingerPrint
 *
 * This class manages finger print access using the Fprint class
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2023 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Phoundation\Processes
 */
class FingerPrint extends DataEntry
{
    public static function getTable(): string
    {
        return 'fingerprints';
    }


    public static function getDataEntryName(): string
    {
        return tr('Fingerprint');
    }


    public static function getUniqueField(): ?string
    {
        return 'users_id';
    }


    /**
     * Enrolls the specified user
     *
     * @param UserInterface $user
     * @return $this
     */
    public static function enroll(UserInterface $user): static
    {
        return new static();
    }


    /**
     * Verifies the specified user
     *
     * @param UserInterface $user
     * @return $this
     */
    public static function verify(UserInterface $user): static
    {
        return new static();
    }


    /**
     * Deletes fingerprints for the specified user
     *
     * @param string|null $comments
     * @return FingerPrint The amount of removed fingerprints
     */
    public function delete(?string $comments = null): static
    {
        // TODO Remove the fingerprint from fprint

        return parent::delete($comments);
    }


    /**
     * Lists the available fingerprints for the specified user
     *
     * @param UserInterface $user
     * @return FingerPrintsInterface
     */
    public static function list(UserInterface $user): FingerPrintsInterface
    {
        return FingerPrints::new();
    }


    protected function setDefinitions(DefinitionsInterface $definitions): void
    {
        // TODO: Implement initDefinitions() method.
    }
}
