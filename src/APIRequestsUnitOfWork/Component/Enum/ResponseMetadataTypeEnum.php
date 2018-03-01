<?php

namespace OutCloud\APIRequestsUnitOfWork\Component\Enum;

use MyCLabs\Enum\Enum;

/**
 * Class ResponseMetadataTypeEnum
 * @package OutCloud\APIRequestsUnitOfWork\Component\Enum
 * @method static SINGLE_ITEM()
 * @method static MULTI_ITEM()
 * @method static ERROR()
 */
class ResponseMetadataTypeEnum extends Enum
{
    public const SINGLE_ITEM = 'single-item';
    public const MULTI_ITEM = 'multi-item';
    public const ERROR = 'error';
}