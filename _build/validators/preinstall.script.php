<?php
/**
 * Validator Checks - Local Weather Build Script
 *
 * Copyright 2012 Gold Coast Media Ltd
 *
 * Local Weather is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * Local Weather is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Local Weather; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package     localweather
 * @subpackage  build
 */

/* The $modx object is not available here. In its place we
 * use $object->xpdo
 */
$modx =& $object->xpdo;


$modx->log(xPDO::LOG_LEVEL_INFO, 'Checking requirements.');
switch($options[xPDOTransport::PACKAGE_ACTION]) {
	
	case xPDOTransport::ACTION_INSTALL:
		$modx->log(xPDO::LOG_LEVEL_INFO, 'Checking requirements');
		$success = true;

		// Check cURL
		if (!in_array('curl', get_loaded_extensions())) {
			$modx->log(xPDO::LOG_LEVEL_ERROR, '** IMPORTANT: You must 
			have the cURL extension to install this plugin. I do plan 
			to add other methods but cURL is the only supported 
			currently.');
			$success = FALSE;
		}
        	break;

	case xPDOTransport::ACTION_UPGRADE:
		$success = true;
		break;

	case xPDOTransport::ACTION_UNINSTALL:
		$success = true;
		break;
}

return $success;
