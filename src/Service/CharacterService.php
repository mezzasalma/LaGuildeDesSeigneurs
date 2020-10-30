<?php


namespace App\Service;


use App\Entity\Character;
use Symfony\Component\HttpFoundation\JsonResponse;

class CharacterService implements CharacterServiceInterface
{
    /**
     * {@inheritdoc
     */
    public function create()
    {
        $character = new Character();
        $character
            ->setKind('Dame')
            ->setName('Maeglin')
            ->setSurname('Oeil Vif')
            ->setCaste('Archer')
            ->setKnowledge('Nombres')
            ->setIntelligence(100)
            ->setLife(14)
            ->setImage('https://images.app.goo.gl/qVwoWSZuWrf4C6BE8')
            ->setCreation(new\DateTime('now'))
        ;
        return $character;
    }
}