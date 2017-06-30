<?php
namespace EloBoostBundle\Form\DataTransformer;

use EloBoostBundle\Entity\Invitation;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

/**
 * Transforms an Invitation to an invitation code.
 */
class InvitationToCodeTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform($value)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof Invitation) {
            throw new UnexpectedTypeException($value, 'EloBoostBundle\Entity\Invitation');
        }

        return $value->getCode();
    }

    public function reverseTransform($value)
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $dql = <<<DQL
SELECT i
FROM EloBoostBundle:Invitation i
WHERE i.code = :code
AND NOT EXISTS(SELECT 1 FROM EloBoostBundle:FUser u WHERE u.invitation = i)
DQL;

            return $this->entityManager
                ->createQuery($dql)
                ->setParameter('code', $value)
                ->setMaxResults(1)
                ->getOneOrNullResult();
        }
    }