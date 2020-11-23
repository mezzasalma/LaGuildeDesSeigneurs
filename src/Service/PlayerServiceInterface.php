<?php


namespace App\Service;

use App\Entity\Player;

interface PlayerServiceInterface
{
    /**
     * Creates the character
     */
    public function create(string $data);

    /**
     * Checks if the entity has been well filled
     */
    public function isEntityFilled(Player $player);

    /**
     * Submits the data to hydrate the object
     */
    public function submit (Player $player, $formName, $data);

    /**
     * Gets all the characters
     */
    public function getAll();

    /**
     * Modifies the character
     * @param Player $player
     */
    public function modify(Player $player, string $data);

    /**
     * Deletes the character
     * @param Player $player
     */
    public function delete(Player $player);
}