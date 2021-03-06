<?php
/**
 * Setup autoloading for the tests.
 *
 * PHP version 5
 *
 * Copyright 2011-2013 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (GPLv2). If
 * you did not receive this file, see
 * http://www.horde.org/licenses/gpl.
 *
 * @category   Horde
 * @package    Wicked
 * @subpackage UnitTests
 * @author     Gunnar Wrobel <wrobel@pardus.de>
 * @link       http://www.horde.org/apps/wicked
 * @license    http://www.horde.org/licenses/gpl GNU General Public License, version 2
 */

Horde_Test_Autoload::addPrefix('Wicked', __DIR__ . '/../../lib');
Horde_Test_Autoload::addPrefix('Text/Wiki/Render/Rst', __DIR__ . '/../../lib/Text_Wiki/Render/Rst');

/** Load the basic test definition */
require_once __DIR__ . '/TestCase.php';
