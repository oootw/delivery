<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Authorize\Token;

use App\Application\Authorize\Entity\Token\Token;
use App\Application\Authorize\Entity\Token\TokenRepositoryInterface;
use App\Infrastructure\Doctrine\Domain\Authorize\Token\Token as AuthorizeToken;
use App\Infrastructure\Doctrine\Domain\Authorize\User\User;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Override;

/**
 * @extends ServiceEntityRepository<AuthorizeToken>
 */
class TokenRepository extends ServiceEntityRepository implements TokenRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuthorizeToken::class);
    }

    #[Override]
    public function findTokenPairBySessionId(string $sessionId): ?Token
    {
        $token = $this->createQueryBuilder('t')
            ->andWhere('t.id = :sessionId')
            ->andWhere('t.expiresAt > :now')
            ->setParameter('sessionId', $sessionId)
            ->setParameter('now', time())
            ->getQuery()
            ->getOneOrNullResult();

        return $token instanceof AuthorizeToken ? $this->toDomain($token) : null;
    }

    #[Override]
    public function revokeTokensBySessionId(string $sessionId): void
    {
        $this->createQueryBuilder('t')
            ->update()
            ->set('t.expiresAt', ':now')
            ->where('t.id = :sessionId')
            ->setParameter('now', time())
            ->setParameter('sessionId', $sessionId)
            ->getQuery()
            ->execute();
    }

    #[Override]
    public function revokeTokensByUserSessionId(int $userId): void
    {
        $now = time();

        $this->createQueryBuilder('t')
            ->update()
            ->set('t.expiresAt', ':now')
            ->where('t.user = :user')
            ->andWhere('t.expiresAt > :now')
            ->setParameter('user', $this->getEntityManager()->getReference(User::class, $userId))
            ->setParameter('now', $now)
            ->getQuery()
            ->execute();
    }

    #[Override]
    public function isSessionActive(string $sessionId): bool
    {
        return $this->findTokenPairBySessionId($sessionId) !== null;
    }

    #[Override]
    public function save(Token $token): void
    {
        $entity = new AuthorizeToken();
        $entity->setId($token->sessionId);
        $entity->setUser($this->getEntityManager()->getReference(User::class, $token->userId));
        $entity->setRefreshToken($token->refreshToken);
        $entity->setExpiresAt($token->expiresAt);
        $entity->setCreatedAt(DateTimeImmutable::createFromMutable($token->createdAt));

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    private function toDomain(AuthorizeToken $token): Token
    {
        return Token::buildNew(
            sessionId: $token->getId(),
            userId: $token->getUser()->getId(),
            refreshToken: $token->getRefreshToken(),
            expiresAt: $token->getExpiresAt(),
            createdAt: DateTime::createFromImmutable($token->getCreatedAt()),
        );
    }
}
