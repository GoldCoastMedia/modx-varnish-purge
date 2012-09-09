<?php
/**
 * Varnish Purge
 *
 * Copyright (c) 2012 Gold Coast Media <dan@goldcoastmedia.co.uk>.
 *
 * This file is part of Varnish Purge for MODx.
 *
 * Varnish Purge is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * Varnish Purge is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Varnish Purge for MODx; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * Default English Topic for Varnish Purge for MODx.
 *
 * @package     varnishpurge
 * @author      Dan Gibbs <dan@goldcoastmedia.co.uk>
 * @copyright   Copyright (c) 2012 Gold Coast Media Ltd
 * @subpackage  lexicon
 * @language    en
 */
$_lang['varnishpurge'] = 'Varnish Purge';

// Errors
$_lang['varnishpurge.purge_success'] = 'Successfully purged [[+url]]';
$_lang['varnishpurge.purge_success'] = 'Failed to purge [[+url]]. Server response: [[+code]].';

// Settings
$_lang['setting_varnishpurge.debug'] = 'Debug Purges';
$_lang['setting_varnishpurge.debug_desc'] = 'Enable this to have purge responses sent to the MODx error log.';
$_lang['setting_varnishpurge.domains'] = 'Domains to Purge';
$_lang['setting_varnishpurge.domains_desc'] = 'A comma separated list of domains to purge when the cache is cleared.';
$_lang['setting_varnishpurge.enabled'] = 'Enable Plugin';
$_lang['setting_varnishpurge.enabled_desc'] = 'Enable / Disable the plugin from firing.';
$_lang['setting_varnishpurge.timeout'] = 'Request Timeout';
$_lang['setting_varnishpurge.timeout_desc'] = 'The amount of seconds to allow for each individual connection. NOTE: Set this low to prevent long delays when saving documents.';

