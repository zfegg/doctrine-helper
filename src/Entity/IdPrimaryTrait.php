<?php

namespace Zfegg\DoctrineHelper\Entity;

use Doctrine\ORM\Mapping as ORM;

trait IdPrimaryTrait
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
}
