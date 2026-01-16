<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        // Si le compte est désactivé, on bloque ici
        if (!$user->isActif()) { // adapte selon ton getter: getActif() ou isActif()
            throw new CustomUserMessageAccountStatusException(
                'Votre compte a été désactivé. Veuillez contacter un administrateur.'
            );
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        // Rien de spécial après authentification dans ton cas
    }
}