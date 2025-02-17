<?php
/**
 * Этот файл является частью расширения модуля веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Backend\Config\IpWhiteList\Model;

use Gm\Helper\IpHelper;
use Gm\Panel\Helper\ExtField;
use Gm\Panel\Data\Model\FormModel;

/**
 * Модель данных профиля IP-адреса.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Backend\Config\IpWhiteList\Model
 * @since 1.0
 */
class Form extends FormModel
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
            'fields'     => [
                ['id'],
                [ // IP-адрес / Маска
                    'address',
                    'label' => 'IP address / Range / Mask'
                ],
                [ // описание
                    'note',
                    'label' => 'Note'
                ],
                ['backend'], // доступность для панели управления
                ['frontend'], // доступность для сайта
                ['range_begin', 'alias' => 'rangeBegin'], // начало диапазона (число)
                ['range_end', 'alias' => 'rangeEnd'], // конец диапазона (число)
                ['range_address', 'alias' => 'rangeAddress'], // диапазон IP-адресов (строка)
            ],
            // правила форматирования полей
            'formatterRules' => [
                [['backend', 'frontend'], 'logic']
            ],
            // правила валидации полей
            'validationRules' => [
                [['address'], 'notEmpty']
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
            ->on(self::EVENT_AFTER_SAVE, function ($isInsert, $columns, $result, $message) {
                /** @var \Gm\Panel\Controller\GridController $controller */
                $controller = $this->controller();
                // всплывающие сообщение
                $this->response()
                    ->meta
                        ->cmdPopupMsg($message['message'], $message['title'], $message['type']);
                // обновить список
                $controller->cmdReloadGrid();
            })
            ->on(self::EVENT_AFTER_DELETE, function ($result, $message) {
                /** @var \Gm\Panel\Controller\GridController $controller */
                $controller = $this->controller();
                // всплывающие сообщение
                $this->response()
                    ->meta
                        ->cmdPopupMsg($message['message'], $message['title'], $message['type']);
                // обновить список
                $controller->cmdReloadGrid();
            });
    }

    /**
     * {@inheritdoc}
     */
    public function afterValidate(bool $isValid): bool
    {
        if ($isValid) {
            // диапазон IP-адресов
            $range   = IpHelper::ip2range($this->address, true);
            $version = IpHelper::getIpVersion($this->address);
            if ($range === false) {
                $this->addError($this->errorFormatMsg($this->t('Incorrect IP address'), 'IP address / Range / Mask'));
                return false;
            }
            if (is_array($range)) {
                $this->rangeBegin = $range[0];
                $this->rangeEnd   = $range[1];
                if ($version === IpHelper::IPV4) {
                    $from = long2ip($range[0]);
                    $to   = long2ip($range[1]);
                    if (!($from === false || $to === false)) {
                        $this->rangeAddress  = $from . ' - ' . $to;
                    }
                }
            } else {
                $this->rangeBegin = $range;
                $this->rangeEnd   = $range;
                $this->rangeAddress = $this->address;
            }
        }
        return $isValid;
    }
}
