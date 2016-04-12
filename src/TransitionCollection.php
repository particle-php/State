<?php
namespace Particle\State;

use Particle\State\Exception\DuplicateTransition;
use Particle\State\Exception\NoSuchTransition;

class TransitionCollection
{
    /** @var Transition[] */
    protected $transitions = [];

    /**
     * @param Transition[] $transitions
     */
    public function __construct(array $transitions = [])
    {
        array_map([$this, 'addTransition'], $transitions);
    }

    /**
     * @param string $name
     * @param Transition $transition
     * @return Transition
     * @throws DuplicateTransition
     */
    public function addTransition($name, Transition $transition)
    {
        if (array_key_exists($name, $this->transitions)) {
            throw DuplicateTransition::forTransitionName($name);
        }

        $this->transitions[$name] = $transition;
    }

    /**
     * @param string $transitionName
     * @return Transition
     * @throws NoSuchTransition
     */
    public function get($transitionName)
    {
        if (!array_key_exists($transitionName, $this->transitions)) {
            throw NoSuchTransition::forTransitionName($transitionName);
        }

        return $this->transitions[$transitionName];
    }
}

