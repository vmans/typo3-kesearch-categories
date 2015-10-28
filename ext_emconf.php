<?php
$EM_CONF[$_EXTKEY] = array (
  'title' => 'Categories for ke_search',
  'description' => 'Description for ext',
  'category' => 'Example Extensions',
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
  'clearCacheOnLoad' => 0,
  'lockType' => '',
  'version' => '0.0.2',
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '7.0.0-7.99.99',
    ),
    'conflicts' => 
    array (
    ),
    'suggests' => 
    array (
    ),
  ),
  'autoload' => 
  array (
    'psr-4' => 
    array (
      'Pws\\KesearchCategories\\' => 'Classes',
    ),
  ),
  'autoload-dev' => 
  array (
    'psr-4' => 
    array (
      'Pws\\KesearchCategories\\Tests\\' => 'Tests',
    ),
  ),
);
