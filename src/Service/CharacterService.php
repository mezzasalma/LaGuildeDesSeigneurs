<?php


namespace App\Service;


use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class CharacterService implements CharacterServiceInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

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
            ->setIdentifier(hash('sha1',uniqid()))
        ;

        $this->em->persist($character);
        $this->em->flush();

        return $character;
    }
}