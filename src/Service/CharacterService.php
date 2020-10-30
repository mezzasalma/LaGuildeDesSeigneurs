<?php


namespace App\Service;


use App\Entity\Character;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class CharacterService implements CharacterServiceInterface
{
    private $em;
    private $characterRepository;

    public function __construct(
        CharacterRepository $characterRepository,
        EntityManagerInterface $em
    ){
        $this->characterRepository = $characterRepository;
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
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

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        $characterFinal = array();
        $characters = $this->characterRepository->findAll();
        foreach ($characters as $character) {
            $characterFinal[] = $character->toArray();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function modify(Character $character)
    {
        $character
            ->setKind('Seigneur')
            ->setName('Gorthol')
            ->setSurname('Haume de terreur')
            ->setCaste('Chevalier')
            ->setKnowledge('Diplomatie')
            ->setIntelligence(110)
            ->setLife(13)
            ->setImage('https://images.app.goo.gl/uAQU4XVCSNRkX1CVA')
            ->setCreation(new\DateTime('now'))
        ;

        $this->em->persist($character);
        $this->em->flush();

        return $character;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Character $character)
    {
        $this->em->remove($character);
        $this->em->flush();

        return true;
    }
}