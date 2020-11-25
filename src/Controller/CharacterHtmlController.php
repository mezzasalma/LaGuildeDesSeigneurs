<?php

namespace App\Controller;

use App\Entity\Character;
use App\Form\CharacterHtmlType;
use App\Repository\CharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\CharacterServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/character")
 */
class CharacterHtmlController extends AbstractController
{
    private $characterService;

    public function __construct(CharacterServiceInterface $characterService)
    {
        $this->characterService = $characterService;
    }

    /**
     * @Route("/index.html", name="character_index_html", methods={"GET"})
     */
    public function index(CharacterRepository $characterRepository): Response
    {
        return $this->render('character/index.html.twig', [
            'characters' => $characterRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="character_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('characterCreate',null);

        $character = new Character();
        $form = $this->createForm(CharacterHtmlType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->characterService->createFromHtml($character);

            return $this->redirectToRoute('character_show', array(
                'id' => $character->getId(),
            ));

//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($character);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('character_index');
        }

        return $this->render('character/new.html.twig', [
            'character' => $character,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="character_show", methods={"GET"})
     */
    public function show(Character $character): Response
    {
        return $this->render('character/show.html.twig', [
            'character' => $character,
        ]);
    }

    /**
     * @Route("/show/intelligence/{intelligence}", name="character_showByIntelligence", methods={"GET"})
     */
    public function showByIntelligence(int $intelligence, CharacterRepository $characterRepository): Response
    {
        $this->denyAccessUnlessGranted('characterIndex');

        return $this->render('character/showByIntelligence.html.twig', [
            'characters' => $characterRepository->findAllByIntelligence($intelligence),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="character_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Character $character): Response
    {
        $this->denyAccessUnlessGranted('characterModify', $character);

        $form = $this->createForm(CharacterHtmlType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->characterService->modifyFromHtml($character);

            return $this->redirectToRoute('character_show', array(
                'id' => $character->getId(),
            ));
        }

        return $this->render('character/edit.html.twig', [
            'character' => $character,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="character_delete_html", methods={"DELETE"})
     */
    public function delete(Request $request, Character $character): Response
    {
        if ($this->isCsrfTokenValid('delete'.$character->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($character);
            $entityManager->flush();
        }

        return $this->redirectToRoute('character_index');
    }
}
