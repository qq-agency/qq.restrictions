<?php

namespace QQ\Restrictions\Event;

use Bitrix\Main\EventResult;
use QQ\Restrictions\Delivery\ExcludeUserGroup;

class Delivery
{
    public function register() {
        return new EventResult(
            EventResult::SUCCESS,
            [
                ExcludeUserGroup::class => getLocalPath('/modules/qq.restrictions/lib/delivery/excludeusergroup.php'),
            ]
        );
    }
}