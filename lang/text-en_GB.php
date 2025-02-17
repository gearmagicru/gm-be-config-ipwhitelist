<?php
/**
 * Этот файл является частью расширения модуля веб-приложения GearMagic.
 * 
 * Пакет английской (британской) локализации.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

return [
    '{name}'        => 'IP Whitelist',
    '{description}' => 'User access to the control panel and website only from specified IP addresses',
    '{permissions}' => [
        'any'  => ['Full access', 'Configuring IP Whitelist']
    ],

    // Grid: фильтр
    'Filter' => 'Filter',
    'Filtering records in the list' => 'Filtering records in the list',
    'IP addresses are available for:' => 'IP addresses are available for:',
    'for backend and frontend' => 'for backend and frontend',
    'for backend' => 'backend',
    'for frontend' => 'frontend',
    // Grid: контекстное меню записи
    'Edit record' => 'Edit record',
    // Grid: столбцы
    'IP address / Range / Mask' => 'IP address / Range / Mask',
    'IP addresses checked when accessing the control panel' => 'IP addresses checked when accessing the control panel',
    'IP addresses checked when accessing the site' => 'IP addresses checked when accessing the site',
    'Range' => 'Range',
    'IP address range' => 'IP address range',
    'Note' => 'Note',

    // Form
    '{form.title}' => 'Adding an IP address',
    '{form.titleTpl}' => 'Updating IP address "{address}"',
    // Form: поля
    'IP address writing format' => 'IP Address writing format for IPv4:<br>' 
    . '- 1.2.3.4 (IP address format)<br>'
    . '- 1.2.3.* (wildcard format)<br>'
    . '- 1.2.3.4/24 or  1.2.3.4/255.255.255.0 (CIDR format)<br>'
    . '- 1.2.3.0-1.2.3.255 (the format of the start and end of the IP address)',
    'IP address are available for' => 'The IP address is available for',
    // Form: сообщения / ошибки
    'Incorrect IP address' => 'Incorrect IP address format',
    'yes' => 'yes',
    'no' => 'no',
    // Form: сообщения / заголовки
    'Enabled' => 'Enabled',
    'Disabled' => 'Disabled',
    // Form: сообщения / текст
    'IP address «{0}» - enabled for backend' => 'IP address «<b>{0}</b>» - enabled for backend',
    'IP address «{0}» - enabled for frontend' => 'IP address «<b>{0}</b>» - enabled for frontend',
    'IP address «{0}» - disabled for backend' => 'IP address «<b>{0}</b>» - disabled for backend',
    'IP address «{0}» - disabled for frontend' => 'IP address «<b>{0}</b>» - disabled for frontend',
    'enabled IP address {0}' => 'enabled IP address «<b>{0}</b>»',
    'disabled IP address {0}' => 'disabled IP address «<b>{0}</b>»'
];
