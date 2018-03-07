<?php
namespace OutCloud\APIRequestsUnitOfWork;

class Config
{
    /** @var bool */
    private $cacheEnabled = true;
    /** @var bool */
    private $autoRunEnabled = false;
    /** @var bool */
    private $asyncEnabled = true;

    /**
     * @return bool
     */
    public function isCacheEnabled(): bool
    {
        return $this->cacheEnabled;
    }

    /**
     * @param bool $cacheEnabled
     */
    public function setCacheEnabled(bool $cacheEnabled): void
    {
        $this->cacheEnabled = $cacheEnabled;
    }

    /**
     * @return bool
     */
    public function isAutoRunEnabled(): bool
    {
        return $this->autoRunEnabled;
    }

    /**
     * @param bool $autoRunEnabled
     */
    public function setAutoRunEnabled(bool $autoRunEnabled): void
    {
        $this->autoRunEnabled = $autoRunEnabled;
    }

    /**
     * @return bool
     */
    public function isAsyncEnabled(): bool
    {
        return $this->asyncEnabled;
    }

    /**
     * @param bool $asyncEnabled
     */
    public function setAsyncEnabled(bool $asyncEnabled): void
    {
        $this->asyncEnabled = $asyncEnabled;
    }


}