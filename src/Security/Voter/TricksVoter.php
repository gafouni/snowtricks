<?php

namespace App\Security\Voter;

use App\Entity\Trick;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TricksVoter extends Voter
{
    public const EDIT = 'trick_edit';
    public const DELETE = 'trick_delete';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
 
    protected function supports(string $attribute, $trick): bool
    {
        
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $trick instanceof Trick;
    }

    protected function voteOnAttribute(string $attribute, $trick, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        //On verifie si l'utilisateur est admin, alors il peut modifier
        if($this->security->isGranted('ROLE_ADMIN')) return true;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                return $this->canEdit($trick, $user);
                break;
            case self::DELETE:
                // logic to determine if the user can DELETE
                // return true or false
                return $this->canDelete($trick, $user);
                break;
        }

        return false;
    }

    private function canEdit(Trick $trick, $user){
        //L'auteur de la figure peut la modifier
        return $user === $trick->getUser();
    }

    private function canDelete(Trick $trick, $user){
        //L'auteur de la figure peut la supprimer
        
        return $user === $trick->getUser();
    }


}
