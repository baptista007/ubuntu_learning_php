<?php

/**
 * Menu Items
 * All Project Menu
 * @category  Menu List
 */
class Menu {
    public static $navbarsideleft = array(
        array(
            'path' => 'home',
            'label' => 'Dashboard',
            'icon' => 'fa-tachometer-alt'
        ),
        array(
            'path' => 'manufacturing',
            'label' => 'Manage',
            'icon' => 'building',
            'submenu' => array(
                array(
                    'path' => 'manufacturing/index',
                    'label' => 'Erven Information',
                    'icon' => ''
                ),
                array(
                    'path' => 'manufacturing/operations',
                    'label' => 'Development',
                    'icon' => ''
                ),
                array(
                    'path' => 'manufacturing/routing',
                    'label' => 'Sales Contracts',
                    'icon' => ''
                ),
                array(
                    'path' => 'manufacturing/routing',
                    'label' => 'Sales Contracts',
                    'icon' => ''
                )
            )
        ),
        array(
            'path' => 'developers',
            'label' => 'Developers',
            'icon' => 'hard-hat',
            'submenu' => array(
                array(
                    'path' => 'manufacturing/index',
                    'label' => 'List',
                    'icon' => ''
                ),
                array(
                    'path' => 'manufacturing/operations',
                    'label' => 'Add New',
                    'icon' => ''
                )
            )
        ),
        array(
            'path' => '#',
            'label' => 'Configuration',
            'icon' => 'cogs',
            'submenu' => array(
                array(
                    'path' => 'core/basic_configuration',
                    'label' => 'Basic Configuration',
                    'icon' => ''
                ),
                array(
                    'path' => 'users',
                    'label' => 'Users',
                    'icon' => ''
                ),
                array(
                    'path' => 'inventory_categories',
                    'label' => 'Inventory Categories',
                    'icon' => ''
                )
            )
        ),
        array(
            'path' => 'home',
            'label' => 'Logout',
            'icon' => 'sign-out'
        )
    );
}