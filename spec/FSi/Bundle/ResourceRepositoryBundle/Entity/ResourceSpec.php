<?php

namespace spec\FSi\Bundle\ResourceRepositoryBundle\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResourceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('FSi\Bundle\ResourceRepositoryBundle\Entity\Resource');
    }

    function it_have_default_bool_value()
    {
        $this->getBoolValue()->shouldReturn(false);
    }
}
