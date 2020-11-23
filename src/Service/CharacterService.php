<?php


namespace App\Service;


use App\Entity\Character;
use App\Repository\CharacterRepository;
use App\Form\CharacterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CharacterService implements CharacterServiceInterface
{
    private $em;
    private $characterRepository;
    private $formFactory;
    private $validator;

    public function __construct(
        CharacterRepository $characterRepository,
        EntityManagerInterface $em,
        FormFactoryInterface $formFactory,
        ValidatorInterface $validator
    ){
        $this->characterRepository = $characterRepository;
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $data)
    {
        $character = new Character();
        $character
            ->setIdentifier(hash('sha1',uniqid()))
            ->setCreation(new\DateTime('now'))
            ->setModification(new\DateTime('now'))
        ;
        $this->submit($character, CharacterType::class, $data);
        $this->isEntityFilled($character);

        $this->em->persist($character);
        $this->em->flush();

        return $character;
    }

    /**
     * {@inheritdoc}
     */
    public function isEntityFilled(Character $character)
    {
        $errors = $this->validator->validate($character);
        if(count($errors)>0) {
            throw new UnprocessableEntityHttpException((string) $errors. ' Missing data for Entity -> ' . json_encode($character->toArray()));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submit($character, $formName, $data)
    {
        $dataArray = is_array($data) ? $data : json_decode($data, true);

        //Bad array
        if (null !== $data && !is_array($dataArray)) {
            throw new UnprocessableEntityHttpException('Submitted data is not an array -> ' . $data);
        }

        //Submits form
        $form = $this->formFactory->create($formName, $character, ['csrf_protection' => false]);
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
    public function getAll()
    {
        $characterFinal = array();
        $characters = $this->characterRepository->findAll();
        foreach ($characters as $character) {
            $characterFinal[] = $character->toArray();
        }

        return $characterFinal;
    }

    /**
     * {@inheritdoc}
     */
    public function modify(Character $character, string $data)
    {
        $this->submit($character, CharacterType::class, $data);
        $this->isEntityFilled($character);
        $character
            ->setModification(new\DateTime('now'))
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