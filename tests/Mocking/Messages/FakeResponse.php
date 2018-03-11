<?php

namespace Gregoriohc\Moneta\Tests\Mocking\Messages;

use Gregoriohc\Moneta\Common\Messages\AbstractResponse;

class FakeResponse extends AbstractResponse
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return count($this->data()) > 0;
    }
}
