<?php
/**
 * Этот файл является частью расширения модуля веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Backend\Config\IpWhiteList\Model;

use Gm\Panel\Data\Model\FormModel;

/**
 * Модель данных профиля записи IP-адреса.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Backend\Config\IpWhiteList\Model
 * @since 1.0
 */
class GridRow extends FormModel
{
    /**
     * {@inheritdoc}
     */
    public function getDataManagerConfig(): array
    {
        return [
            'tableName'  => '{{ip_whitelist}}',
            'primaryKey' => 'id',
            'fields'     => [
                ['id'],
                ['backend'], // доступность для панели управления
                ['frontend'], // доступность для сайта
                ['address'] // IP-адрес / Маска
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
                if ($message['success']) {
                    if (isset($columns['backend'])) {
                        $enabled = filter_var($columns['backend'], FILTER_VALIDATE_BOOLEAN);
                        $message['message'] = $this->module->t('IP address «{0}» - ' . ($enabled ? 'enabled' : 'disabled') . ' for backend', [$this->address]);
                        $message['title']   = $this->t($enabled ? 'Enabled' : 'Disabled');
                    } else
                    if (isset($columns['frontend'])) {
                        $enabled = filter_var($columns['frontend'], FILTER_VALIDATE_BOOLEAN);
                        $message['message'] = $this->module->t('IP address «{0}» - ' . ($enabled ? 'enabled' : 'disabled') . ' for frontend', [$this->address]);
                        $message['title']   = $this->t($enabled ? 'Enabled' : 'Disabled');
                    }
                }
                // всплывающие сообщение
                $this->response()
                    ->meta
                        ->cmdPopupMsg($message['message'], $message['title'], $message['type']);
            });
    }
}
