<?php
/**
 * Этот файл является частью расширения модуля веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Backend\Config\IpWhiteList\Controller;

use Gm;
use Gm\Panel\Helper\ExtGrid;
use Gm\Panel\Helper\HtmlGrid;
use Gm\Mvc\Module\BaseModule;
use Gm\Panel\Widget\TabGrid;
use Gm\Panel\Controller\GridController;
use Gm\Panel\Helper\HtmlNavigator as HtmlNav;

/**
 * Контроллер белого списка IP-адресов.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Backend\Config\IpWhiteList\Controller
 * @since 1.0
 */
class Grid extends GridController
{
    /**
     * {@inheritdoc}
     * 
     * @var BaseModule|\Gm\Backend\Config\IpWhiteList\Extension
     */
    public BaseModule $module;

    /**
     * {@inheritdoc}
     */
    public function createWidget(): TabGrid
    {
        /** @var TabGrid $tab Сетка данных (Gm.view.grid.Grid GmJS) */
        $tab = parent::createWidget();

        // столбцы (Gm.view.grid.Grid.columns GmJS)
        $tab->grid->columns = [
            ExtGrid::columnNumberer(),
            ExtGrid::columnAction(),
            [
                'text'      => ExtGrid::columnInfoIcon($this->t('IP address / Range / Mask')),
                'dataIndex' => 'address',
                'cellTip'   => HtmlGrid::tags([
                    HtmlGrid::header('{address}'),
                    HtmlGrid::fieldLabel($this->t('Range'), '{rangeAddress}'),
                    HtmlGrid::fieldLabel($this->t('Note'), '{note}'),
                    ['fieldset',
                        [
                            HtmlGrid::legend($this->t('IP address are available for')),
                            HtmlGrid::fieldLabel(
                                $this->t('for backend'), 
                                HtmlGrid::tplChecked('backend==1')
                            ),
                            HtmlGrid::fieldLabel(
                                $this->t('for frontend'),
                                HtmlGrid::tplChecked('frontend==1')
                            ),
                        ]
                    ]
                ]),
                'filter'    => ['type' => 'string'],
                'sortable'  => true,
                'width'     => 250
            ],
            [
                'text'      => '#IP address range',
                'dataIndex' => 'rangeAddress',
                'cellTip'   => '{rangeAddress}',
                'filter'    => ['type' => 'string'],
                'sortable'  => true,
                'width'     => 220
            ],
            [
                'text'        => ExtGrid::columnIcon('g-icon-m_frontend', 'svg'),
                'tooltip'     => '#IP addresses checked when accessing the site',
                'xtype'       => 'g-gridcolumn-switch',
                'filter'      => ['type' => 'boolean'],
                'collectData' => ['address'],
                'dataIndex'   => 'frontend',
            ],
            [
                'text'        => ExtGrid::columnIcon('g-icon-m_backend', 'svg'),
                'tooltip'     => '#IP addresses checked when accessing the control panel',
                'xtype'       => 'g-gridcolumn-switch',
                'filter'      => ['type' => 'boolean'],
                'collectData' => ['address'],
                'dataIndex'   => 'backend'
            ],
            [
                'text'      => '#Note',
                'dataIndex' => 'note',
                'cellTip'   => '{note}',
                'filter'    => ['type' => 'string'],
                'sortable'  => true,
                'width'     => 150
            ],
        ];

        // панель инструментов (Gm.view.grid.Grid.tbar GmJS)
        $tab->grid->tbar = [
            'padding' => 1,
            'items'   => ExtGrid::buttonGroups([
                'edit',
                'columns',
                // группа инструментов "Поиск"
                'search' => [
                    'items' => [
                        'help',
                        'search',
                        // инструмент "Фильтр"
                        'filter' => ExtGrid::popupFilter([
                            [
                                'xtype' => 'label',
                                'text'  => '#IP addresses are available for:',
                                'ui'    => 'header'
                            ],
                            [
                                'xtype'      => 'radio',
                                'boxLabel'   => '#for backend and frontend',
                                'name'       => 'side',
                                'inputValue' => 'both',
                            ],
                            [
                                'xtype'      => 'radio',
                                'boxLabel'   => '#for backend',
                                'name'       => 'side',
                                'inputValue' => 'backend',
                            ],
                            [
                                'xtype'      => 'radio',
                                'boxLabel'   => '#for frontend',
                                'name'       => 'side',
                                'inputValue' => 'frontend',
                                'checked'    => true
                            ]
                        ], [
                            'action' => $this->module->route('/grid/filter', true),
                        ])
                    ]
                ]
            ], [
                'route' => $this->module->route()
            ])
        ];

        // контекстное меню записи (Gm.view.grid.Grid.popupMenu GmJS)
        $tab->grid->popupMenu = [
            'cls'        => 'g-gridcolumn-popupmenu',
            'titleAlign' => 'center',
            'width'      => 150,
            'items'      => [
                [
                    'text'        => '#Edit record',
                    'iconCls'     => 'g-icon-svg g-icon-m_edit g-icon-m_color_default',
                    'handlerArgs' => [
                        'route'   => Gm::alias('@route', '/form/view/{id}'),
                        'pattern' => 'grid.popupMenu.activeRecord'
                    ],
                    'handler' => 'loadWidget'
                ]
            ]
        ];

        // 2-й клик по строке сетки
        $tab->grid->rowDblClickConfig = [
            'allow' => true,
            'route' => $this->module->route('/form/view/{id}')
        ];
        // количество строк в сетке
        $tab->grid->store->pageSize = 50;
        // поле аудита записи
        $tab->grid->logField = 'address';
        // плагины сетки
        $tab->grid->plugins = 'gridfilters';
        // класс CSS применяемый к элементу body сетки
        $tab->grid->bodyCls = 'g-grid_background';

        // панель навигации (Gm.view.navigator.Info GmJS)
        $tab->navigator->info['tpl'] = HtmlNav::tags([
            HtmlNav::header('{address}'),
            HtmlNav::fieldLabel($this->t('Range'), '{rangeAddress}'),
            HtmlNav::tplIf(
                'note',
                HtmlNav::fieldLabel($this->t('Note'), '{note}'),
                ''
            ),
            ['fieldset',
                [
                    HtmlNav::legend($this->t('IP address are available for')),
                    HtmlNav::fieldLabel(
                        ExtGrid::columnIcon('g-icon-m_backend', 'svg') . ' ' . $this->t('for backend'),
                        HtmlNav::tplChecked('backend==1')
                    ),
                    HtmlNav::fieldLabel(
                        ExtGrid::columnIcon('g-icon-m_frontend', 'svg') . ' ' . $this->t('for frontend'),
                        HtmlNav::tplChecked('frontend==1')
                    )
                ]
            ],
            HtmlNav::widgetButton(
                $this->t('Edit record'),
                ['route' => Gm::alias('@route', '/form/view/{id}'), 'long' => true],
                ['title' => $this->t('Edit record')]
            )
        ]);

        $tab
            ->addCss('/grid.css')
            ->addRequire('Gm.view.grid.column.Switch');
        return $tab;
    }
}
