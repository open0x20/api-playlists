<?php

namespace App\Dto\Request;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class DeleteDto
 * @package App\Dto\Request
 */
class DeleteDto
{
    /**
     * @Assert\NotNull()
     * @var integer
     */
    public $playlistId;
}
