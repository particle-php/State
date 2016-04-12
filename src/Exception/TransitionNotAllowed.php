<?php

namespace Particle\State\Exception;

use Particle\State\Exception;

class TransitionNotAllowed extends \Exception implements Exception
{
    public static function forTransitionName($transitionName)
    {
        return new self(
            sprintf('Transition "%s" is not allowed in the current state', $transitionName)
        );
    }
}
