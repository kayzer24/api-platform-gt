<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\PersonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotIdenticalTo;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get', 'put', 'delete'],
    attributes: ['pagination_enabled' => false],
)]
#[ApiFilter(SearchFilter::class, properties: [
    'firstName' => SearchFilter::STRATEGY_PARTIAL,
    'lastName' => SearchFilter::STRATEGY_PARTIAL
])]
#[ApiFilter(OrderFilter::class,
    properties: ['firstName', 'lastName'],
    arguments: ['orderParameterName' => 'order']
)]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['item'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[NotBlank]
    #[Groups(['item'])]
    private string $firstName;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[NotBlank]
    #[NotIdenticalTo(propertyPath: 'firstName')]
    #[Groups(['item'])]
    private  string $lastName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }
}
