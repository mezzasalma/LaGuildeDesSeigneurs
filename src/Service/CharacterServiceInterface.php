<?php


namespace App\Service;


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
}