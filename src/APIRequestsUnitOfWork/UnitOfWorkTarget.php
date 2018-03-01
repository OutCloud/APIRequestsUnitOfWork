<?php

namespace OutCloud\APIRequestsUnitOfWork;


use OutCloud\APIRequestsUnitOfWork\Exception\TargetIsNotProcessedException;

class UnitOfWorkTarget
{
    /** @var string */
    private $targetHash;
    /** @var mixed */
    private $target;
    /** @var Callable|null */
    private $callback;
    /** @var Callable|null */
    private $requestCreator;
    /** @var Callable|null */
    private $responseParser;
    /** @var ResponseMetadata|null */
    private $metadata;
    /** @var object|array */
    private $response;
    /** @var bool */
    private $isProcessed;

    /**
     * UnitOfWorkTarget constructor.
     * @param mixed $target
     * @param Callable $callback
     * @param Callable $requestCreator
     * @param Callable $responseParser
     */
    public function __construct($target, ?Callable $callback = null, ?Callable $requestCreator = null, ?Callable $responseParser = null)
    {
        $this->targetHash = \spl_object_hash($target);
        $this->target = $target;
        $this->callback = $callback;
        $this->requestCreator = $requestCreator;
        $this->responseParser = $responseParser;
        $this->isProcessed = false;
    }

    /**
     * @return array|object
     * @throws TargetIsNotProcessedException
     */
    public function getResponse()
    {
        if (!$this->isProcessed) {
            throw new TargetIsNotProcessedException("Response for this target is not ready. It needs to be processed");
        }

        return $this->response;
    }

    /**
     * @return string
     */
    public function getTargetHash(): string
    {
        return $this->targetHash;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return bool
     */
    public function isProcessed(): bool
    {
        return $this->isProcessed;
    }

    /**
     * @return Callable|null
     */
    public function getCallback(): ?Callable
    {
        return $this->callback;
    }

    /**
     * @return Callable|null
     */
    public function getRequestCreator(): ?Callable
    {
        return $this->requestCreator;
    }

    /**
     * @return Callable|null
     */
    public function getResponseParser(): ?Callable
    {
        return $this->responseParser;
    }

}