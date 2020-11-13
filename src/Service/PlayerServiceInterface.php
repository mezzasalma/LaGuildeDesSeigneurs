<?php


namespace App\Service;

use App\Entity\Player;

interface PlayerServiceInterface
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
     * @param Player $player
     */
    public function modify(Player $player);

    /**
     * Deletes the character
     * @param Player $player
     */
    public function delete(Player $player);
}