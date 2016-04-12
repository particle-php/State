<?php
namespace Particle\State\Tests;

use Particle\State\Exception\DuplicateTransition;
use Particle\State\Exception\NoSuchTransition;
use Particle\State\Exception\TransitionNotAllowed;
use Particle\State\State;
use Particle\State\StateCollection;
use Particle\State\StateMachine;
use Particle\State\Transition;
use PHPUnit_Framework_TestCase as TestCase;


class StateMachineTest extends TestCase
{
    /** @var StateMachine */
    protected $machine;

    public function setUp()
    {
        $this->machine = StateMachine::withStates(State::withName('pending'), StateCollection::withStates([
            State::withName('pending'),
            State::withName('started'),
            State::withName('accepted'),
            State::withName('rejected'),
            State::withName('completed'),
            State::withName('failed'),
        ]));

        $this->machine->addTransition(Transition::withStates('start', ['pending'], 'started'));
        $this->machine->addTransition(Transition::withStates('accept', ['started'], 'accepted'));
    }

    public function testCanReturnsTrueIfCurrentStateAllowsTransition()
    {
        $this->assertTrue($this->machine->canApplyTransition('start'));
    }

    public function testCanReturnFalseIfCurrentStateDoesNotAllowTransition()
    {
        $this->assertFalse($this->machine->canApplyTransition('accept'));
    }

    public function testApplyChangesStateIfCurrentStateAllowsTransition()
    {
        $this->machine->transition('start');

        $this->assertFalse($this->machine->canApplyTransition('start'));
        $this->assertTrue($this->machine->canApplyTransition('accept'));
    }

    public function testApplyThrowsExceptionIfCurrentStateDoesNotAllowTransition()
    {
        $this->setExpectedException(
            TransitionNotAllowed::class,
            'Transition "accept" is not allowed in the current state'
        );

        $this->machine->transition('accept');
    }

    public function testApplyThrowsExceptionOnUnknownTransition()
    {
        $this->setExpectedException(
            NoSuchTransition::class,
            'There is no transition registered with the name "foo"'
        );

        $this->machine->transition('foo');
    }

    public function testAddTransitionThrowsExceptionOnDuplicateTransitionName()
    {
        $this->setExpectedException(
            DuplicateTransition::class,
            'Can not overwrite the transaction with name "start"'
        );

        $this->machine->addTransition(Transition::withStates('start', ['pending'], 'started'));
    }
}
