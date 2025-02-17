<?php
/**
 * Этот файл является частью расширения модуля веб-приложения GearMagic.
 * 
 * Пакет русской локализации.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

return [
    '{name}'        => 'Белый список IP-адресов',
    '{description}' => 'Доступ пользователей к панели управления и сайту только с указанных IP-адресов',
    '{permissions}' => [
        'any'  => ['Полный доступ', 'Настройка белого списка IP-адресов']
    ],

    // Grid: фильтр
    'Filter' => 'Фильтр',
    'Filtering records in the list' => 'Фильтрация записей',
    'IP addresses are available for:' => 'IP-адреса доступны для:',
    'for backend and frontend' => 'панели управления и сайта',
    'for backend' => 'панели управления',
    'for frontend' => 'сайта',
    // Grid: контекстное меню записи
    'Edit record' => 'Редактировать',
    // Grid: столбцы
    'IP address / Range / Mask' => 'IP-адрес / Маска',
    'IP addresses checked when accessing the control panel' => 'IP-адреса проверяемые при доступе к панели управления',
    'IP addresses checked when accessing the site' => 'IP-адреса проверяемые при доступе к сайту',
    'Range' => 'Диапазон',
    'IP address range' => 'Диапазон IP-адресов',
    'Note' => 'Описание',

    // Form
    '{form.title}' => 'Добавление IP-адреса',
    '{form.titleTpl}' => 'Изменение IP-адреса "{address}"',
    // Form: поля
    'IP address writing format' => 'Формат записи IP-адреса для IPv4:<br>' 
    . '- 1.2.3.4 (формат IP-адреса)<br>'
    . '- 1.2.3.* (формат подстановочного знака)<br>'
    . '- 1.2.3.4/24 или 1.2.3.4/255.255.255.0 (CIDR формат)<br>'
    . '- 1.2.3.0-1.2.3.255 (формат начала и конца IP-адреса)',
    'IP address are available for' => 'IP-адрес доступен для',
    // Form: сообщения / ошибки
    'Incorrect IP address' => 'Неправильно указан формат IP-адреса',
    'yes' => 'да',
    'no' => 'нет',
    // Form: сообщения / заголовки
    'Enabled' => 'Подключен',
    'Disabled' => 'Отключен',
    // Form: сообщения / текст
    'IP address «{0}» - enabled for backend' => 'IP-адрес «<b>{0}</b>» - подключен для панели управления',
    'IP address «{0}» - enabled for frontend' => 'IP-адрес «<b>{0}</b>» - подключен для сайта',
    'IP address «{0}» - disabled for backend' => 'IP-адрес «<b>{0}</b>» - отключен для панели управления',
    'IP address «{0}» - disabled for frontend' => 'IP-адрес «<b>{0}</b>» - отключен для сайта',
    'enabled IP address {0}' => 'подключение IP-адреса «<b>{0}</b>»',
    'disabled IP address {0}' => 'отключение IP-адреса «<b>{0}</b>»'
];
