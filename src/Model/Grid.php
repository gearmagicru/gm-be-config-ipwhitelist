<?php
/**
 * Этот файл является частью расширения модуля веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Backend\Config\IpWhiteList\Model;

use Gm\Panel\Data\Model\GridModel;

/**
 * Модель данных белого списка IP-адресов.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Backend\Config\IpWhiteList\Model
 * @since 1.0
 */
class Grid extends GridModel
{
    /**
     * {@inheritdoc}
     */
    public function getDataManagerConfig(): array
    {
        return [
            'useAudit'   => true,
            'tableName'  => '{{ip_whitelist}}',
            'primaryKey' => 'id',
            'order'      => ['address' => 'ASC'],
            'fields'     => [
                ['address'], // IP-адрес / Маска
                ['note'], // описание
                ['backend'], // доступность для панели управления
                ['frontend'], // доступность для сайта
                ['range_address', 'alias' => 'rangeAddress'] // диапазон IP-адресов (строка)
            ],
            'order' => [
                'backend' => 'ASC'
            ],
            'resetIncrements' => ['{{ip_whitelist}}'],
            'filter' => [
                'side' => ['operator' => '='],
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        $this
            ->on(self::EVENT_AFTER_DELETE, function ($someRecords, $result, $message) {
                // всплывающие сообщение
                $this->response()
                    ->meta
                        ->cmdPopupMsg($message['message'], $message['title'], $message['type']);
                /** @var \Gm\Panel\Controller\GridController $controller */
                $controller = $this->controller();
                // обновить список
                $controller->cmdReloadGrid();
            })
            ->on(self::EVENT_AFTER_SET_FILTER, function ($filter) {
                /** @var \Gm\Panel\Controller\GridController $controller */
                $controller = $this->controller();
                // обновить список
                $controller->cmdReloadGrid();
            });
    }

    /**
     * {@inheritdoc}
     */
    protected function onSetFilter(array &$filter): void
    {
        // если установлен фильтр
        if (isset($filter[0])) {
            // если выбрана доступность IP-адреса для:
            if ($filter[0]['property'] === 'side') {
                switch ($filter[0]['value']) {
                    // не доступен для панели управления и сайта
                    case 'none':
                        $filter[0] = [
                            'value'    => 0,
                            'property' => 'backend',
                            'operator' => '=',
                            'where'    => null
                        ];
                        $filter[1] = [
                            'value'    => 0,
                            'property' => 'frontend',
                            'operator' => '=',
                            'where'    => null
                        ];
                    break;

                    // панели управления и сайта
                    case 'both':
                        $filter[0] = [
                            'value'    => 1,
                            'property' => 'backend',
                            'operator' => '=',
                            'where'    => null
                        ];
                        $filter[1] = [
                            'value'    => 1,
                            'property' => 'frontend',
                            'operator' => '=',
                            'where'    => null
                        ];
                    break;

                    // панели управления
                    case 'backend':
                        $filter[0] = [
                            'value'    => 1,
                            'property' => 'backend',
                            'operator' => '=',
                            'where'    => null
                        ];
                    break;

                    // сайта
                    case 'frontend':
                        $filter[0] = [
                            'value'    => 1,
                            'property' => 'frontend',
                            'operator' => '=',
                            'where'    => null
                        ];
                    break;
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prepareRow(array &$row): void
    {
        // заголовок контекстного меню записи
        $row['popupMenuTitle'] = $row['address'];
    }
}
