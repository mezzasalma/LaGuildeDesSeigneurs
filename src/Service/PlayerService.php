<?php


namespace App\Service;


use App\Entity\Player;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class PlayerService implements PlayerServiceInterface
{
    private $em;
    private $playerRepository;

    public function __construct(
        PlayerRepository $playerRepository,
        EntityManagerInterface $em
    ){
        $this->playerRepository = $playerRepository;
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        $playerFinal = array();
        $players = $this->playerRepository->findAll();
        foreach ($players as $player) {
            $playerFinal[] = $player->toArray();
        }

        return $playerFinal;
    }

    /**
     * {@inheritdoc}
     */
    public function create() {
        $player = new Player();
        $player
            ->setFirstname('Maeva')
            ->setLastname('Mezzasalma')
            ->setAge(21)
            ->setEmail('maeva.mezzasalma@edu.gobelins.fr')
            ->setMirian(500)
            ->setIdentifier(hash('sha1',uniqid()))
            ->setCreation(new\DateTime('now'))
            ->setModification(new\DateTime('now'))
            ;
        $this->em->persist($player);
        $this->em->flush();

        return $player;
    }

    /**
     * {@inheritdoc}
     */
    public function modify(Player $player)
    {
        $player
            ->setAge(22)
            ->setMirian(730)
            ->setModification(new\DateTime('now'))
        ;
        $this->em->persist($player);
        $this->em->flush();

        return $player;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Player $player)
    {
        $this->em->remove($player);
        $this->em->flush();

        return true;
    }
}