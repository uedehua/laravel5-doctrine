<?php

namespace UeDehua\LaravelDoctrine\Provider;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserProviderInterface;
use Illuminate\Contracts\Hashing\Hasher;

class DoctrineOrmUserProvider implements UserProviderInterface
{

    /**
     * @var HasherInterface
     */
    private $hasher;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var string
     */
    private $entity;

    /**
     * @param \Illuminate\Contracts\Hashing\Hasher $hasher
     * @param EntityManager $entityManager
     * @param $entity
     */
    public function __construct(Hasher $hasher, EntityManager $entityManager, $entity)
    {
        $this->hasher = $hasher;
        $this->em = $entityManager;
        $this->entity = $entity;
    }

    /**
     * Retrieve a user by their unique identifier.
     * @param  mixed $identifier
     * @return UserInterface|null
     */
    public function retrieveById($identifier)
    {
        return $this->getRepository()->find($identifier);
    }

    /**
     * Retrieve a user by by their unique identifier and "remember me" token.
     * @param  mixed $identifier
     * @param  string $token
     * @return UserInterface|null
     */
    public function retrieveByToken($identifier, $token)
    {
        $entity = $this->getEntity();
        return $this->getRepository()->findOneBy([
                    $entity->getKeyName() => $identifier,
                    $entity->getRememberTokenName() => $token
        ]);
    }

    /**
     * Update the "remember me" token for the given user in storage.
     * @param  UserInterface $user
     * @param  string $token
     * @return void
     */
    public function updateRememberToken(UserInterface $user, $token)
    {
        $user->setRememberToken($token);
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * Retrieve a user by the given credentials.
     * @param  array $credentials
     * @return UserInterface|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $criteria = [];
        foreach ($credentials as $key => $value)
            if (!strstr($key, 'password')) {
                $criteria[$key] = $value;
            }
        return $this->getRepository()->findOneBy($criteria);
    }

    /**
     * Validate a user against the given credentials.
     * @param  UserInterface $user
     * @param  array $credentials
     * @return bool
     */
    public function validateCredentials(UserInterface $user, array $credentials)
    {
        return $this->hasher->check($credentials['password'], $user->getAuthPassword());
    }

    /**
     * Returns repository for the entity.
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    private function getRepository()
    {
        return $this->em->getRepository($this->entity);
    }

    /**
     * Returns instantiated entity.
     *
     * @return mixed
     */
    private function getEntity()
    {
        return new $this->entity;
    }

}
