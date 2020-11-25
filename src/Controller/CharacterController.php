<?php

namespace App\Controller;

use App\Entity\Character;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\CharacterServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

class CharacterController extends AbstractController
{
    private $characterService;

    public function __construct(CharacterServiceInterface $characterService)
    {
        $this->characterService = $characterService;
    }

    //INDEX
    /**
     * Displays available Characters
     *
     * @Route("/character/index",
     *     name="character_index",
     *     methods={"GET","HEAD"}
     * )
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\Schema(
     *          type="array",
     *          @OA\Items(ref=@Model(type=Character::class))
     *      )
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\Tag(name="Character")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        $characters = $this->characterService->getAll();
        return new JsonResponse($characters);
    }

    /**
     * Redirects to index Route
     *
     * @Route("/character",
     *     name="character_redirect_index",
     *     methods={"GET","HEAD"}
     * )
     * @OA\Response(
     *     response=302,
     *     description="Redirect",
     * )
     * @OA\Tag(name="Character")
     */
    public function redirectIndex()
    {
        return $this->redirectToRoute('character_index');
    }

    //DISPLAY
    /**
     * Displays the Character
     *
     * @Route("/character/display/{identifier}",
     *     name="character_display",
     *     requirements={"identifier":"^([a-z0-9]{40})$"},
     *     methods={"GET","HEAD"}
     * )
     * @Entity("character", expr="repository.findOneByIdentifier(identifier)")
     * @OA\Parameter(
     *     name="identifier",
     *     in="path",
     *     description="identifier for the Character",
     *     required=true,
     * )
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @Model(type=Character::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\Response(
     *     response=404,
     *     description="Not Found",
     * )
     * @OA\Tag(name="Character")
     */
    public function display(Character $character)
    {
//        dump($character);
//        dd($character->toArray()); // dump & die donc ne return rien
        $this->denyAccessUnlessGranted('characterDisplay', $character);

        return new JsonResponse($character->toArray());
    }

    //DISPLAY INTELLIGENCE
    /**
     * Displays Characters by Intelligence
     *
     * @Route("/character/display/intelligence/{intelligence}",
     *     name="character_display_intelligence",
     *     requirements={"intelligence":"^([0-9]{1,3})$"},
     *     methods={"GET","HEAD"}
     * )
     * @OA\Parameter(
     *     name="intelligence",
     *     in="path",
     *     description="intelligence of Characters",
     *     required=true,
     * )
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @Model(type=Character::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\Response(
     *     response=404,
     *     description="Not Found",
     * )
     * @OA\Tag(name="Character")
     */
    public function displayByIntelligence(int $intelligence)
    {
        $this->denyAccessUnlessGranted('characterIndex', null);

        $characters = $this->characterService->getByIntelligence($intelligence);

        return new JsonResponse($characters);
//        return new JsonResponse($character->toArray());
    }

    //CREATE
    /**
     * Creates the Character
     *
     * @Route("/character/create",
     *     name="character_create",
     *     methods={"POST","HEAD"}
     * )
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @Model(type=Character::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\RequestBody(
     *     request="Character",
     *     description="Data for the Character",
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/Character")
     *     )
     * )
     * @OA\Tag(name="Character")
     */
    public function create(Request $request)
    {
        $this->denyAccessUnlessGranted('characterCreate', null);

        $character = $this->characterService->create($request->getContent());

        return new JsonResponse($character->toArray());
    }

    //MODIFY
    /**
     * Modifies the Character
     *
     * @Route("/character/modify/{identifier}",
     *     name="character_modify",
     *     requirements={"identifier":"^([a-z0-9]{40})$"},
     *     methods={"PUT","HEAD"}
     *     )
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @Model(type=Character::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\Parameter(
     *     name="identifier",
     *     in="path",
     *     description="identifier for the Character",
     *     required=true,
     * )
     * @OA\RequestBody(
     *     request="Character",
     *     description="Data for the Character",
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/Character")
     *     )
     * )
     * @OA\Tag(name="Character")
     */
    public function modify(Request $request, Character $character)
    {
        $this->denyAccessUnlessGranted('characterModify', $character);

        $character = $this->characterService->modify($character, $request->getContent());

        return new JsonResponse($character->toArray());
    }

    //DELETE
    /**
     * Deletes the Character
     *
     * @Route("/character/delete/{identifier}",
     *     name="character_delete",
     *     requirements={"identifier":"^([a-z0-9]{40})$"},
     *     methods={"DELETE","HEAD"}
     * )
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
     *     description="identifier for the Character",
     *     required=true,
     * )
     * @OA\Tag(name="Character")
     */
    public function delete(Character $character)
    {
        $this->denyAccessUnlessGranted('characterDelete', $character);

        $response = $this->characterService->delete($character);

        return new JsonResponse(array('delete'=>$response));
    }
}
