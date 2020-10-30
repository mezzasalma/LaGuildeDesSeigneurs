<?php


namespace App\Service;


use App\Entity\Character;

interface CharacterServiceInterface
{
    /**
     * Creates the character
     */
    public function create();

    /**
     * Gets all the characters
     */
    public function getAll();

    /**
     * Modifies the character
     */
    public function modify(Character $character);

    /**
    * Deletes the character
    */
    public function delete(Character $character);
}