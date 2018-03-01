<?php

namespace OutCloud\APIRequestsUnitOfWork;

use Doctrine\Common\Collections\ArrayCollection;
use OutCloud\APIRequestsUnitOfWork\Exception\TargetDoesNotExistException;
use Symfony\Component\Cache\Simple\AbstractCache;

class AbstractAPIRequestUnitOfWork
{
    /** @var AbstractCache */
    private $cache;
    /** @var Config */
    private $config;
    /** @var ArrayCollection */
    private $targets;


    /**
     * AbstractCumulatedUnitOfWork constructor.
     * @param AbstractCache $cache
     */
    public function __construct(AbstractCache $cache)
    {
        $this->cache = $cache;
        $this->targets = new ArrayCollection();
    }

    /**
     * @param UnitOfWorkTarget[] ...$targets
     */
    public function registerTargets(UnitOfWorkTarget ...$targets): void
    {
        /** @var UnitOfWorkTarget $target */
        foreach ($targets as $target) {
            if ($this->targets->get($target->getTargetHash()) !== null) {
                $this->targets->set($target->getTargetHash(), $target);
            }
        }
    }

    /**
     * @param $target
     * @throws TargetDoesNotExistException
     */
    public function invalidateTarget($target): void
    {
        $target = $this->getUnitOfWorkTargetForTarget($target);

        if (!$target instanceof UnitOfWorkTarget) {
            throw new TargetDoesNotExistException("UnitOfWorkTarget couldn't be found");
        }

        $this->targets->removeElement($target);
    }

    /**
     * @param $target
     * @return null|UnitOfWorkTarget
     */
    public function getUnitOfWorkTargetForTarget($target): ?UnitOfWorkTarget
    {
        return $this->targets->map(function(UnitOfWorkTarget $t) use ($target){
            return $t->getTarget() === $target;
        })->first() ?: null;
    }



}