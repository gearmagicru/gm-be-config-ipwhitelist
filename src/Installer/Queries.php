<?php
/**
 * Этот файл является частью расширения модуля веб-приложения GearMagic.
 * 
 * Файл конфигурации Карты SQL-запросов.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

return [
    'drop'   => ['{{ip_whitelist}}'],
    'create' => [
        '{{ip_whitelist}}' => function () {
            return "CREATE TABLE `{{ip_whitelist}}` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `address` varchar(50) DEFAULT NULL,
                `range_begin` int(11) unsigned DEFAULT NULL,
                `range_end` varchar(255) DEFAULT NULL,
                `range_address` varchar(100) DEFAULT NULL,
                `expired` datetime DEFAULT NULL,
                `note` varchar(255) DEFAULT NULL,
                `backend` tinyint(1) unsigned DEFAULT '1',
                `frontend` tinyint(1) unsigned DEFAULT '1',
                `_updated_date` datetime DEFAULT NULL,
                `_updated_user` int(11) unsigned DEFAULT NULL,
                `_created_date` datetime DEFAULT NULL,
                `_created_user` int(11) unsigned DEFAULT NULL,
                `_lock` tinyint(1) unsigned DEFAULT '0',
                PRIMARY KEY (`id`)
            ) ENGINE={engine} 
            DEFAULT CHARSET={charset} COLLATE {collate}";
        }
    ],

    'run' => [
        'install'   => ['drop', 'create'],
        'uninstall' => ['drop']
    ]
];