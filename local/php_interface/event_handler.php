<?php

use Bitrix\Main\EventManager;

EventManager::getInstance()->addEventHandler(
    'main',
    'OnUserTypeBuildList',
    [MTai\UserField\ElementByUser::class, 'getDescription']
);