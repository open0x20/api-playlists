<?php

namespace App\Dto\Request;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CreateDto
 * @package App\Dto\Request
 */
class CreateDto
{
    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(min="1", max="100")
     *
     * @var string
     */
    public $owner;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(min="1", max="255")
     *
     * @var string
     */
    public $name;
}
