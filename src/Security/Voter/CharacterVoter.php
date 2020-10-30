<?php

namespace App\Security\Voter;

use App\Entity\Character;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CharacterVoter extends Voter
{
    public const CHARACTER_CREATE = 'characterCreate';
    public const CHARACTER_DISPLAY = 'characterDisplay';

    private const ATTRIBUTES = array(
        self::CHARACTER_CREATE,
        self::CHARACTER_DISPLAY
    );

    protected function supports($attribute, $subject)
    {
        if(null!== $subject){
            return $subject instanceof Character && in_array($attribute, self::ATTRIBUTES);
        }

        return in_array($attribute, self::ATTRIBUTES);
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        //Defines access rights
        switch ($attribute) {
            case self::CHARACTER_CREATE:
                return $this->canCreate();
                break;

            case self::CHARACTER_DISPLAY:
                // Peut envoyer $token e $subject pour tester des conditions
                return $this->canDisplay(); // $this->>canDisplay($token,$subject)
            break;
        }

        throw new LogicException('Invalid attribute:'.$attribute);
    }

    /**
     * Checks if is allowed to create
     */
    private function canCreate() {
        return true;
    }

    /**
     * Checks if is allowed to display
     */
    private function canDisplay() {
        return true;
    }
}
