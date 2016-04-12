<?php

namespace Particle\State\Exception;

use Particle\State\Exception;

class DuplicateTransition extends \Exception implements Exception
{
    public static function forTransitionName($transitionName)
    {
        return new self(
            sprintf('Can not overwrite the transaction with name "%s"', $transitionName)
        );
    }
}
