<?php

abstract class posPlugin
{
    /** @var modX $modx */
    protected $modx;
    /** @var pointsOfSale $pos */
    protected $pos;
    /** @var array $sp */
    protected $sp;

    /**
     * @param pointsOfSale $pos
     * @param array        $sp
     */
    public function __construct(pointsOfSale &$pos, array &$sp)
    {
        $this->pos = &$pos;
        $this->modx = &$this->pos->modx;
        $this->sp = &$sp;
    }

    // abstract public function run();
}