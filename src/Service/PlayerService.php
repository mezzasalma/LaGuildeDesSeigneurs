<?php


namespace App\Service;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use LogicException;
use App\Event\PlayerEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PlayerService implements PlayerServiceInterface
{
    private $em;
    private $playerRepository;
    private $formFactory;
    private $validator;
    private $dispatcher;

    public function __construct(
        PlayerRepository $playerRepository,
        EntityManagerInterface $em,
        FormFactoryInterface $formFactory,
        ValidatorInterface $validator,
        EventDispatcherInterface $dispatcher
    ) {
        $this->playerRepository = $playerRepository;
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->validator = $validator;
        $this->dispatcher = $dispatcher;
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
    public function create(string $data)
    {
        $player = new Player();
        $player
            ->setIdentifier(hash('sha1', uniqid()))
            ->setCreation(new \DateTime('now'))
            ->setModification(new \DateTime('now'))
            ;
        $this->submit($player, PlayerType::class, $data);
        $this->isEntityFilled($player);

        $this->em->persist($player);
        $this->em->flush();

        return $player;
    }

    /**
     * {@inheritdoc}
     */
    public function isEntityFilled(Player $player)
    {
        $errors = $this->validator->validate($player);
        if (count($errors)>0) {
            throw new UnprocessableEntityHttpException((string) $errors. ' Missing data for Entity -> ' . json_encode($player->toArray()));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submit($player, $formName, $data)
    {
        $dataArray = is_array($data) ? $data : json_decode($data, true);

        //Bad array
        if (null !== $data && !is_array($dataArray)) {
            throw new UnprocessableEntityHttpException('Submitted data is not an array -> ' . $data);
        }

        //Submits form
        $form = $this->formFactory->create($formName, $player, ['csrf_protection' => false]);
        $form->submit($dataArray, false);//With false, only submitted fields are validated

        //Gets errors
        $errors = $form->getErrors();
        foreach ($errors as $error) {
            throw new LogicException('Error ' . get_class($error->getCause()) . ' --> ' . $error->getMessageTemplate() . ' ' . json_encode($error->getMessageParameters()));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function modify(Player $player, string $data)
    {
        $this->submit($player, PlayerType::class, $data);

        $event = new PlayerEvent($player);
        $this->dispatcher->dispatch($event, PlayerEvent::PLAYER_MODIFIED);

        $this->isEntityFilled($player);
        $player
            ->setModification(new \DateTime('now'))
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
