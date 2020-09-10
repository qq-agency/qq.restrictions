<?php

namespace QQ\Restrictions\Delivery;

use Bitrix\Main\GroupTable;
use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\Delivery\Restrictions;
use Bitrix\Sale\Internals\Entity;

Loc::loadMessages(__FILE__);

class ExcludeUserGroup extends Restrictions\Base
{
    public static function getClassTitle() {
        return Loc::getMessage('QQ_RESTRICTIONS_TITLE');
    }

    public static function getClassDescription() {
        return Loc::getMessage('QQ_RESTRICTIONS_DESCRIPTION');
    }

    public static function getParamsStructure($entityId = 0) {
        return [
            'GROUP_IDS' => [
                'TYPE' => 'ENUM',
                'MULTIPLE' => 'Y',
                'LABEL' => Loc::getMessage('QQ_RESTRICTIONS_GROUPS'),
                'OPTIONS' => static::getUserGroups()
            ]
        ];
    }

    protected static function getUserGroups() {
        $result = [];
        $res = GroupTable::getList([
            'filter' => ['ACTIVE' => 'Y'],
            'order' => ['NAME' => 'ASC']
        ]);

        while ($group = $res->fetch()) {
            $result[$group['ID']] = $group['NAME'];
        }

        return $result;
    }

    public static function check($groups, array $restrictionParams, $entityId = 0) {
        return empty(array_intersect($groups, $restrictionParams['GROUP_IDS']));
    }

    protected static function extractParams(Entity $entity) {
        global $USER;

        return $USER->GetUserGroupArray();
    }
}
