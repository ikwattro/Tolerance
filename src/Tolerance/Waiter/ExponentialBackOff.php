<?php

/*
 * This file is part of the Tolerance package.
 *
 * (c) Samuel ROZE <samuel.roze@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tolerance\Waiter;

class ExponentialBackOff implements Waiter
{
    /**
     * @var Waiter
     */
    private $waiter;

    /**
     * @var int
     */
    private $exponent;

    /**
     * @param Waiter $waiter
     * @param int    $exponent
     */
    public function __construct(Waiter $waiter, $exponent)
    {
        $this->exponent = $exponent;
        $this->waiter = $waiter;
    }

    /**
     * {@inheritdoc}
     */
    public function wait($seconds = 0)
    {
        $time = $this->getNextTime($seconds);

        $this->waiter->wait($time);

        $this->exponent++;
    }

    /**
     * Return the amount of time that will be waited the next `wait` call.
     *
     * @param int $seconds
     *
     * @return int
     */
    public function getNextTime($seconds = 0)
    {
        return $seconds + exp($this->exponent);
    }
}

