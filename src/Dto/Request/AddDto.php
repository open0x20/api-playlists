<?php

namespace App\Dto\Request;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AddDto
 * @package App\Dto\Request
 */
class AddDto
{
    /**
     * @Assert\NotNull()
     * @var integer
     */
    public $playlistId;

    /**
     * @Assert\NotNull()
     * @var integer
     */
    public $trackId;
}
