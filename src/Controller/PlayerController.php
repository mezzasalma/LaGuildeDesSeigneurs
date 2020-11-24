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
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

class PlayerController extends AbstractController
{
    private $playerService;

    public function __construct(PlayerServiceInterface $playerService)
    {
        $this->playerService = $playerService;
    }

    //INDEX
    /**
     * Displays available Players
     *
     * @Route("/player/index",
     *     name="player_index",
     *     methods={"GET","HEAD"}
     * )
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\Schema(
     *          type="array",
     *          @OA\Items(ref=@Model(type=Player::class))
     *      )
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\Tag(name="Player")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('playerIndex', null);
        $players = $this->playerService->getAll();
        return new JsonResponse($players);
    }

    /**
     * Redirects to index Route
     *
     * @Route("/player",
     *     name="player_redirect_index",
     *     methods={"GET","HEAD"}
     * )
     * @OA\Response(
     *     response=302,
     *     description="Redirect",
     * )
     * @OA\Tag(name="Player")
     */
    public function redirectIndex()
    {
        return $this->redirectToRoute('player_index');
    }

    //DISPLAY
    /**
     * Displays the Player
     *
     * @Route("/player/display/{identifier}",
     *     name="player_display",
     *     requirements={"identifier":"^([a-z0-9]{40})$"},
     *     methods={"GET","HEAD"}
     *     )
     * @Entity("player", expr="repository.findOneByIdentifier(identifier)")
     * @OA\Parameter(
     *     name="identifier",
     *     in="path",
     *     description="identifier for the Player",
     *     required=true,
     * )
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @Model(type=Player::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\Response(
     *     response=404,
     *     description="Not Found",
     * )
     * @OA\Tag(name="Player")
     */
    public function display(Player $player)
    {
        $this->denyAccessUnlessGranted('playerDisplay', $player);

        return new JsonResponse($player->toArray());
    }

    //CREATE
    /**
     * Creates the Player
     *
     * @Route("/player/create",
     *     name="player_create",
     *     methods={"POST","HEAD"}
     * )
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @Model(type=Player::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\RequestBody(
     *     request="Player",
     *     description="Data for the Player",
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/Player")
     *     )
     * )
     * @OA\Tag(name="Player")
     */
    public function create(Request $request)
    {
        $this->denyAccessUnlessGranted('playerCreate', null);

        $player = $this->playerService->create($request->getContent());

        return new JsonResponse($player->toArray());
    }

    //MODIFY
    /**
     * Modifies the Player
     *
     * @Route("/player/modify/{identifier}",
     *     name="player_modify",
     *     requirements={"identifier":"^([a-z0-9]{40})$"},
     *     methods={"PUT","HEAD"}
     * )
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @Model(type=Player::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\Parameter(
     *     name="identifier",
     *     in="path",
     *     description="identifier for the Player",
     *     required=true,
     * )
     * @OA\RequestBody(
     *     request="Player",
     *     description="Data for the Player",
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/Player")
     *     )
     * )
     * @OA\Tag(name="Player")
     */
    public function modify(Request $request, Player $player)
    {
        $this->denyAccessUnlessGranted('playerModify', $player);

        $player = $this->playerService->modify($player, $request->getContent());

        return new JsonResponse($player->toArray());
    }

    //DELETE
    /**
     * Deletes the Player
     *
     * @Route("/player/delete/{identifier}",
     *     name="player_delete",
     *     requirements={"identifier":"^([a-z0-9]{40})$"},
     *     methods={"DELETE","HEAD"})
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\Schema(
     *          @OA\Property(property="delete", type="boolean"),
     *     )
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\Parameter(
     *     name="identifier",
     *     in="path",
     *     description="identifier for the Player",
     *     required=true,
     * )
     * @OA\Tag(name="Player")
     */
    public function delete(Player $player)
    {
        $this->denyAccessUnlessGranted('playerDelete', $player);

        $response = $this->playerService->delete($player);

        return new JsonResponse(array('delete'=>$response));
    }
}
