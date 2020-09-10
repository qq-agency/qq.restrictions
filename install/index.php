<?php

use Bitrix\Main\EventManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use QQ\Restrictions\Event\Delivery;

Loc::loadMessages(__FILE__);

class qq_restrictions extends CModule
{
    public $MODULE_ID = 'qq.restrictions';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $PARTNER_NAME;
    public $PARTNER_URI;
    public $MODULE_GROUP_RIGHTS = 'Y';

    public function __construct() {
        $arModuleVersion = [];
        include __DIR__ . '/version.php';
        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_NAME = Loc::getMessage('QQ_RESTRICTIONS_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('QQ_RESTRICTIONS_MODULE_DESCRIPTION');
        $this->PARTNER_NAME = Loc::getMessage('QQ_RESTRICTIONS_PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('QQ_RESTRICTIONS_PARTNER_URI');
    }

    public function DoInstall() {
        $this->InstallEvents();

        ModuleManager::registerModule($this->MODULE_ID);

        return true;
    }

    public function InstallEvents() {
        $eventManager = EventManager::getInstance();
        $eventManager->registerEventHandler(
            'sale',
            'onSaleDeliveryRestrictionsClassNamesBuildList',
            $this->MODULE_ID,
            Delivery::class,
            'register'
        );
    }

    public function DoUninstall() {
        $this->UnInstallEvents();

        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    public function UnInstallEvents() {
        $eventManager = EventManager::getInstance();
        $eventManager->unRegisterEventHandler(
            'sale',
            'onSaleDeliveryRestrictionsClassNamesBuildList',
            $this->MODULE_ID,
            Delivery::class,
            'register'
        );
    }
}
