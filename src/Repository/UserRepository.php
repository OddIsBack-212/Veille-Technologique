<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function loadUserByUsername($username)
    {

        return $this->createQueryBuilder('u')
            ->where('u.prenom = prenom OR u.mail = :mail')
            ->setParameter('prenom', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();

    }

    public function checkMail($mail)
    {
        $case = 0;
        if (preg_match("/@eni-ecole.fr/i", strval($mail)) && false !== filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $case = 1;
        } elseif (preg_match("/@campus-eni.fr/i", strval($mail)) && false !== filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $case = 2;
        } else {
            $case = 3;
        }
        return $case;
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findOneBySomeField($value): ?User
    {


        return $this->createQueryBuilder('u')
            ->andWhere('u.formateur = :true')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
