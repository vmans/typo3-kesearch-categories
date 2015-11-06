<?php

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['modifyFilters'][] = 'Pws\\KesearchCategories\\Hooks\\FilterOptionHook';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['modifyPagesIndexEntry'][] = 'Pws\\KesearchCategories\\Hooks\\IndexPagesHook';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['modifyContentIndexEntry'][] = 'Pws\\KesearchCategories\\Hooks\\IndexContentHook';