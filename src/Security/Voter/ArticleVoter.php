<?php

namespace App\Security\Voter;

use App\Entity\Article;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticleVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['EDIT', 'DELETE'])
            && $subject instanceof Article;
    }

    protected function voteOnAttribute($attribute, $article, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if (null === $article->getAuthor()){
            return false;
        }

        switch ($attribute) {
            case 'EDIT':
            if (($article->getAuthor()->getId() === $user->getId()) ||
                ('ROLE_ADMIN' === $user->getRoles()[0])){
                return true;
            }
            break;
            case 'DELETE':
            if (($article->getAuthor()->getId() === $user->getId()) ||
                ('ROLE_ADMIN' === $user->getRoles()[0])){
                return true;
            }
                break;
        }

        return false;
    }
}
