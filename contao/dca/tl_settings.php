<?php

/*
 * This file is part of cgoit\contao-additional-header-logging-bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2026, cgoIT
 * @author     cgoIT <https://cgo-it.de>
 * @license    LGPL-3.0-or-later
 */

use Contao\CoreBundle\DataContainer\PaletteManipulator;

$GLOBALS['TL_DCA']['tl_settings']['fields']['logging_header_names'] = [
    'search' => true,
    'inputType' => 'text',
    'eval' => ['mandatory' => false, 'maxlength' => 2048, 'tl_class' => 'w100'],
];

PaletteManipulator::create()
    ->addLegend('logging_legend', 'chmod_legend')
    ->addField('logging_header_names', 'logging_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_settings')
;
