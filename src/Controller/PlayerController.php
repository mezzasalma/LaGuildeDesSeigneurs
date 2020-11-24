<?php

namespace App\Controller;

use App\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\PlayerServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class PlayerController extends AbstractController
{
    private $playerService;

    public function __construct(PlayerServiceInterface $playerService)
    {
        $this->playerService = $playerService;
    }

    /**
     * @Route("/player/index",
     *     name="player_index")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('playerIndex', null);
        $players = $this->playerService->getAll();
        return new JsonResponse($players);
    }

    /**
     * @Route("/player",
     *     name="player_redirect_index")
     */
    public function redirectIndex()
    {
        return $this->redirectToRoute('player_index');
    }

    /**
     * @Route("/player/display/{identifier}",
     *     name="player_display",
     *     requirements={"identifier":"^([a-z0-9]{40})$"},
     *     methods={"GET","HEAD"}
     *     )
     * @Entity("player", expr="repository.findOneByIdentifier(identifier)")
     */
    public function display(Player $player)
    {
        $this->denyAccessUnlessGranted('playerDisplay', $player);

        return new JsonResponse($player->toArray());
    }

    /**
     * @Route("/player/create",
     *     name="player_create",
     *     methods={"POST","HEAD"})
     */
    public function create(Request $request)
    {
        $this->denyAccessUnlessGranted('playerCreate', null);

        $player = $this->playerService->create($request->getContent());

        return new JsonResponse($player->toArray());
    }

    /**
     * @Route("/player/modify/{identifier}",
     *     name="player_modify",
     *     requirements={"identifier":"^([a-z0-9]{40})$"},
     *     methods={"PUT","HEAD"})
     * @param Player $player
     * @return JsonResponse
     */
    public function modify(Request $request, Player $player)
    {
        $this->denyAccessUnlessGranted('playerModify', $player);

        $player = $this->playerService->modify($player, $request->getContent());

        return new JsonResponse($player->toArray());
    }

    /**
     * @Route("/player/delete/{identifier}",
     *     name="player_delete",
     *     requirements={"identifier":"^([a-z0-9]{40})$"},
     *     methods={"DELETE","HEAD"})
     * @param Player $player
     * @return JsonResponse
     */
    public function delete(Player $player)
    {
        $this->denyAccessUnlessGranted('playerDelete', $player);

        $response = $this->playerService->delete($player);

        return new JsonResponse(array('delete'=>$response));
    }
}
