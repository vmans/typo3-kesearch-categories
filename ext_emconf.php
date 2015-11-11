<?php
$EM_CONF[$_EXTKEY] = array(
    'title' => 'Categories for ke_search',
    'description' => 'Extension provides categories for ke_search-filteroptions. Categories are used as ke_search-indexable tags for pages and news.',
    'author' => 'Kevin Purrmann',
    'author_email' => 'entwicklung@purrmann-websolutions.de',
    'author_company' => 'Purrmann Websolutions',
    'shy' => '',
    'priority' => '',
    'module' => '',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 1,
    'lockType' => '',
    'version' => '1.1.0',
    'constraints' =>
        array(
            'depends' =>
                array(
                    'typo3' => '6.2.0-7.9.99',
                    'ke_search' => '1.10.2'
                ),
            'conflicts' =>
                array(),
            'suggests' =>
                array(),
        ),
    'autoload' =>
        array(
            'psr-4' =>
                array(
                    'Pws\\KesearchCategories\\' => 'Classes/',
                ),
        ),
    'autoload-dev' =>
        array(
            'psr-4' =>
                array(
                    'Pws\\KesearchCategories\\Tests\\' => 'Tests/',
                ),
        ),
);
