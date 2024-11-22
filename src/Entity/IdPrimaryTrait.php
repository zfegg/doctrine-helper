<?php

namespace Zfegg\DoctrineHelper\Entity;

use Doctrine\ORM\Mapping as ORM;

trait IdPrimaryTrait
{

    /**
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    #[ORM\Column("id", "integer")]
    #[ORM\Id]
    #[ORM\GeneratedValue("IDENTITY")]
    private int $id;
}
