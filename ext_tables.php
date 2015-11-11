<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}


$tempColumns = array(
    'use_categories_for_filter_options' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:kesearch_categories/Resources/Private/Language/locallang_db.xlf:tx_kesearch_filters.use_categories_for_filter_options',
        'config' => array(
            'type' => 'check',
        )
    ),
    'categories' => array(
        'exclude' => 1,
        'l10n_mode' => 'mergeIfNotBlank',
        'displayCond' => 'FIELD:use_categories_for_filter_options:=:1',
        'label' => 'LLL:EXT:kesearch_categories/Resources/Private/Language/locallang_db.xlf:tx_kesearch_filters.categories',
        'config' => array(
            'type' => 'select',
            'renderMode' => 'tree',
            'renderType' => 'selectTree',
            'treeConfig' => array(
                'parentField' => 'parent',
                'appearance' => array(
                    'showHeader' => true,
                    'allowRecursiveMode' => true,
                    'expandAll' => true,
                    'maxLevels' => 99,
                ),
            ),
            'MM' => 'sys_category_record_mm',
            'MM_match_fields' => array(
                'fieldname' => 'categories',
                'tablenames' => 'tx_kesearch_filters',
            ),
            'MM_opposite_field' => 'items',
            'foreign_table' => 'sys_category',
            'foreign_table_where' => ' AND (sys_category.sys_language_uid = 0 OR sys_category.l10n_parent = 0) ' .
                'ORDER BY sys_category.sorting',
            'size' => 10,
            'autoSizeMax' => 20,
            'minitems' => 1,
            'maxitems' => 99,
        )
    ),
    'use_subcategories' => array(
        'exclude' => 1,
        'displayCond' => 'FIELD:use_categories_for_filter_options:=:1',
        'label' => 'LLL:EXT:kesearch_categories/Resources/Private/Language/locallang_db.xlf:tx_kesearch_filters.use_subcategories',
        'config' => array(
            'type' => 'check',
        )
    ),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'tx_kesearch_filters',
    $tempColumns
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_kesearch_filters',
    'use_categories_for_filter_options, categories, use_subcategories'
);

$GLOBALS['TCA']['tx_kesearch_filters']['ctrl']['requestUpdate'] .= ',use_categories_for_filter_options';