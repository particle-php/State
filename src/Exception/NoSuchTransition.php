<?php

namespace Particle\State\Exception;

use Particle\State\Exception;

class NoSuchTransition extends \Exception implements Exception
{
    public static function forTransitionName($transitionName)
    {
        return new self(
            sprintf('There is no transition registered with the name "%s"', $transitionName)
        );
    }
}
