<?php

namespace App\Security\Voter;

use App\Entity\Character;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CharacterVoter extends Voter
{
    public const  CHARACTER_INDEX = 'characterIndex';
    public const CHARACTER_CREATE = 'characterCreate';
    public const CHARACTER_DISPLAY = 'characterDisplay';
    public const CHARACTER_MODIFY = 'characterModify';
    public const CHARACTER_DELETE = 'characterDelete';

    private const ATTRIBUTES = array(
        self::CHARACTER_INDEX,
        self::CHARACTER_CREATE,
        self::CHARACTER_DISPLAY,
        self::CHARACTER_MODIFY,
        self::CHARACTER_DELETE,
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
            case self::CHARACTER_INDEX:
            case self::CHARACTER_CREATE:
                return $this->canCreate();
                break;

            case self::CHARACTER_DISPLAY:
                // Peut envoyer $token en $subject pour tester des conditions
                return $this->canDisplay(); // $this->>canDisplay($token,$subject)
                break;

            case self::CHARACTER_MODIFY:
                return $this->canModify();
                break;

            case self::CHARACTER_DELETE:
                return $this->canDelete();
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
    /**
     * Checks if is allowed to modify
     */
    private function canModify() {
        return true;
    }
    /**
     * Checks if is allowed to delete
     */
    private function canDelete() {
        return true;
    }
}
