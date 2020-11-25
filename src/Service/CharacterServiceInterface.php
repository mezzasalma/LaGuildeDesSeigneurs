<?php


namespace App\Service;

use App\Entity\Character;

interface CharacterServiceInterface
{
    /**
     * Creates the character
     */
    public function create(string $data);

    /**
     * Creates the character from html form
     */
    public function createFromHtml(Character $character);

    /**
     * Checks if the entity has been well filled
     */
    public function isEntityFilled(Character $character);

    /**
     * Submits the data to hydrate the object
     */
    public function submit(Character $character, $formName, $data);

    /**
     * Gets all the characters
     */
    public function getAll();

    /**
     * Gets all the characters with intelligence greater than or equal to a number
     */
    public function getByIntelligence(int $intelligence);

    /**
     * Modifies the character
     * @param Character $character
     */
    public function modify(Character $character, string $data);

    /**
     * Deletes the character
     * @param Character $character
     */
    public function delete(Character $character);
}
