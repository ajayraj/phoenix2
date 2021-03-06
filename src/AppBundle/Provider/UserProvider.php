<?php
namespace AppBundle\Provider;

use AppBundle\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
  protected $userRepository;
  
  public function __construct(ObjectRepository $userRepository)
  {
      $this->userRepository = $userRepository;
  }
  
  public function loadUserByUsername($username)
  {
      $q = $this->userRepository
          ->createQueryBuilder('u')
          ->where('u.email = :email')
          ->setParameter('email', $username)
          ->getQuery();
      try {
          $user = $q->getSingleResult();
      } catch (NoResultException $e) {
          $message = sprintf(
              'Unable to find an active admin AppBundle:User object identified by "%s".',
              $username
          );
          throw new UsernameNotFoundException($message, 0, $e);
      }
      return $user;
  }
  
  public function refreshUser(UserInterface $user)
  {
      $class = get_class($user);
      if (!$this->supportsClass($class)) {
          throw new UnsupportedUserException(
              sprintf(
                  'Instances of "%s" are not supported.',
                  $class
              )
          );
      }
      return $this->userRepository->find($user->getId());
  }
  
  public function supportsClass($class)
  {
      return $this->userRepository->getClassName() === $class
      || is_subclass_of($class, $this->userRepository->getClassName());
  }
  
}