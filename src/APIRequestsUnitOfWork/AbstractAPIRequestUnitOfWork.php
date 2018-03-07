<?php

namespace OutCloud\APIRequestsUnitOfWork;

use Ds\Set;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use OutCloud\APIRequestsUnitOfWork\Exception\TargetDoesNotExistException;
use OutCloud\APIRequestsUnitOfWork\Exception\UnitOfWorkTargetIsNotRegisteredForGivenTargetException;
use Symfony\Component\Cache\Simple\AbstractCache;

class AbstractAPIRequestUnitOfWork
{
    /** @var AbstractCache */
    private $cache;
    /** @var Config */
    private $config;
    /** @var Set */
    private $targets;
    /** @var Client */
    private $client;

    /**
     * AbstractCumulatedUnitOfWork constructor.
     * @param AbstractCache $cache
     * @param null|Config $config
     */
    public function __construct(AbstractCache $cache, Client $guzzleClient, ?Config $config = null)
    {
        $this->cache = $cache;
        $this->config = $config ?? new Config();
        $this->targets = new Set();
        $this->client = $guzzleClient;
    }

    /**
     * @param UnitOfWorkTarget[] ...$targets
     */
    public function registerTargets(UnitOfWorkTarget ...$targets): void
    {
        $this->targets->add(...$targets);
    }

    /**
     * @param UnitOfWorkTarget[] ...$targets
     * @throws TargetDoesNotExistException
     */
    public function invalidateTargets(UnitOfWorkTarget ...$targets): void
    {
        if (!$this->targets->contains(...$targets)) {
            throw new TargetDoesNotExistException("UnitOfWorkTarget couldn't be found");
        }

        $this->targets->remove(...$targets);
    }

    /**
     * @param $target
     * @return null|UnitOfWorkTarget
     * @throws UnitOfWorkTargetIsNotRegisteredForGivenTargetException
     */
    public function getUnitOfWorkTargetForTarget($target): ?UnitOfWorkTarget
    {
        $set = $this->targets->filter(function (UnitOfWorkTarget $t) use ($target) {
            return $t->getTarget() === $target;
        });

        if (!$set->count()) {
            throw new UnitOfWorkTargetIsNotRegisteredForGivenTargetException();
        }

        return $set->first();
    }

    public function processTargets(): void
    {
        /** @var UnitOfWorkTarget $target */
        foreach ($this->targets as $target) {
            $rC = $target->getRequestCreator() ?? [$this, 'getRequest'];
            $request = $rC();

        }
    }

    protected function getReqest($data): Request
    {
        $r = new Request('GET', 'localhost', [], $data);
    }

    private function execRequest(Request $request)
    {
        if ($this->config->isAsyncEnabled()) {
            $this->client->sendAsync($request);
        } else {
            $this->client->send($request);
        }

    }


}