<?php

namespace Gregoriohc\Moneta\Common\Messages;

class BasicResponse extends AbstractResponse
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
