<?php

declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Enum\TenderStatusEnum;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyInfo\Type;

class TenderStatusFilter extends AbstractFilter
{
    public const string FIELD_STATUS = 'status';

    protected function filterProperty(
        string $property,
        $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        ?Operation $operation = null,
        array $context = []
    ): void
    {
        if(
            !$this->isPropertyEnabled($property, $resourceClass)
            || !$this->isPropertyMapped($property, $resourceClass)
        )
        {
            return;
        }

        $alias = $queryBuilder->getRootAliases()[0];
        if(self::FIELD_STATUS === $property)
        {
            if(TenderStatusEnum::STATUS_CLOSE->value === $value)
            {
                $queryBuilder->andWhere($queryBuilder->expr()->eq($alias.'.'.$property, ':status'));
                $queryBuilder->setParameter('status', TenderStatusEnum::STATUS_CLOSE);
            }

            if(TenderStatusEnum::STATUS_OPEN->value === $value)
            {
                $queryBuilder->andWhere($queryBuilder->expr()->eq($alias.'.'.$property, ':status'));
                $queryBuilder->setParameter('status', TenderStatusEnum::STATUS_OPEN);
            }

            if(TenderStatusEnum::STATUS_CANCELED->value === $value)
            {
                $queryBuilder->andWhere($queryBuilder->expr()->eq($alias.'.'.$property, ':status'));
                $queryBuilder->setParameter('status', TenderStatusEnum::STATUS_CANCELED);
            }
        }
    }

    public function getDescription(string $resourceClass): array
    {
        if(!$this->properties)
        {
            return [];
        }
        $description = [];
        foreach($this->properties as $property => $strategy)
        {
            $description[$property] = [
                'property' => $property,
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => false,
                'description' => 'Filtering reservations by status.',
                'schema' => [
                    'type' => 'string',
                    'enum' => [
                        TenderStatusEnum::STATUS_CLOSE->value,
                        TenderStatusEnum::STATUS_OPEN->value,
                        TenderStatusEnum::STATUS_CANCELED->value,
                    ],
                ],
            ];
        }

        return $description;
    }
}
