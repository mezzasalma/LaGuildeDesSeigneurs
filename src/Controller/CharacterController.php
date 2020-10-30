<?php

namespace App\Controller;

use App\Entity\Character;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CharacterServiceInterface;

class CharacterController extends AbstractController
{
    private $characterService;

    public function __construct(CharacterServiceInterface $characterService)
    {
        $this->characterService = $characterService;
    }
    /**
     * @Route("/character",
     *     name="character_index")
     */
    public function index()
    {
        $character = new Character();

        return new JsonResponse($character->toArray());
    }

    /**
     * @Route("/character/display",
     *     name="character_display",
     *     methods={"GET","HEAD"})
     */
    public function display()
    {
        $character = new Character();
//        dump($character);
//        dd($character->toArray()); // dump & die donc ne return rien


        return new JsonResponse($character->toArray());
    }

     /**
      * @Route("/character/create",
      *     name="character_create",
      *     methods={"POST","HEAD"}
      *     )
      */
     public function create()
     {
         $character = $this->characterService->create();
         return new JsonResponse($character->toArray());
     }
}
