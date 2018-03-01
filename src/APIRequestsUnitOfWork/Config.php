<?php
namespace OutCloud\APIRequestsUnitOfWork;

class Config
{
    private $cacheEnabled = true;

    /**
     * @return mixed
     */
    public function getCacheEnabled()
    {
        return $this->cacheEnabled;
    }

    /**
     * @param mixed $cacheEnabled
     */
    public function setCacheEnabled($cacheEnabled)
    {
        $this->cacheEnabled = $cacheEnabled;
    }


}