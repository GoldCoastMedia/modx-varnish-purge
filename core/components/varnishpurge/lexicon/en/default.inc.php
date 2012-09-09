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
$_lang['varnishpurge.purge_fail'] = 'Failed to purge [[+url]]. Server response: [[+code]] ([[+response]])';

// Settings
$_lang['setting_varnishpurge.debug'] = 'Debug Purges';
$_lang['setting_varnishpurge.debug_desc'] = 'Enable this to have purge responses sent to the MODx error log.';
$_lang['setting_varnishpurge.domains'] = 'Domains to Purge';
$_lang['setting_varnishpurge.domains_desc'] = 'A comma separated list of domains to purge when the cache is cleared.';
$_lang['setting_varnishpurge.enabled'] = 'Enable Plugin';
$_lang['setting_varnishpurge.enabled_desc'] = 'Enable / Disable the plugin from firing.';
$_lang['setting_varnishpurge.timeout'] = 'Request Timeout';
$_lang['setting_varnishpurge.timeout_desc'] = 'The amount of seconds to allow for each individual connection. NOTE: Set this low to prevent long delays when saving documents.';

// Standard HTTP responses
$_lang['varnishpurge.rescode_100'] = 'Continue';
$_lang['varnishpurge.rescode_101'] = 'Switching Protocols';
$_lang['varnishpurge.rescode_102'] = 'Processing';
$_lang['varnishpurge.rescode_200'] = 'OK';
$_lang['varnishpurge.rescode_201'] = 'Created';
$_lang['varnishpurge.rescode_202'] = 'Accepted';
$_lang['varnishpurge.rescode_203'] = 'Non-Authoritative Information';
$_lang['varnishpurge.rescode_204'] = 'No Content';
$_lang['varnishpurge.rescode_205'] = 'Reset Content';
$_lang['varnishpurge.rescode_206'] = 'Partial Content';
$_lang['varnishpurge.rescode_207'] = 'Multi-Status';
$_lang['varnishpurge.rescode_300'] = 'Multiple Choices';
$_lang['varnishpurge.rescode_301'] = 'Moved Permanently';
$_lang['varnishpurge.rescode_302'] = 'Found';
$_lang['varnishpurge.rescode_303'] = 'See Other';
$_lang['varnishpurge.rescode_304'] = 'Not Modified';
$_lang['varnishpurge.rescode_305'] = 'Use Proxy';
$_lang['varnishpurge.rescode_306'] = 'Switch Proxy';
$_lang['varnishpurge.rescode_307'] = 'Temporary Redirect';
$_lang['varnishpurge.rescode_400'] = 'Bad Request';
$_lang['varnishpurge.rescode_401'] = 'Unauthorized';
$_lang['varnishpurge.rescode_402'] = 'Payment Required';
$_lang['varnishpurge.rescode_403'] = 'Forbidden';
$_lang['varnishpurge.rescode_404'] = 'Not Found';
$_lang['varnishpurge.rescode_405'] = 'Method Not Allowed';
$_lang['varnishpurge.rescode_406'] = 'Not Acceptable';
$_lang['varnishpurge.rescode_407'] = 'Proxy Authentication Required';
$_lang['varnishpurge.rescode_408'] = 'Request Timeout';
$_lang['varnishpurge.rescode_409'] = 'Conflict';
$_lang['varnishpurge.rescode_410'] = 'Gone';
$_lang['varnishpurge.rescode_411'] = 'Length Required';
$_lang['varnishpurge.rescode_412'] = 'Precondition Failed';
$_lang['varnishpurge.rescode_413'] = 'Request Entity Too Large';
$_lang['varnishpurge.rescode_414'] = 'Request-URI Too Long';
$_lang['varnishpurge.rescode_415'] = 'Unsupported Media Type';
$_lang['varnishpurge.rescode_416'] = 'Requested Range Not Satisfiable';
$_lang['varnishpurge.rescode_417'] = 'Expectation Failed';
$_lang['varnishpurge.rescode_418'] = 'I\'m a teapot';
$_lang['varnishpurge.rescode_422'] = 'Unprocessable Entity';
$_lang['varnishpurge.rescode_423'] = 'Locked';
$_lang['varnishpurge.rescode_424'] = 'Failed Dependency';
$_lang['varnishpurge.rescode_425'] = 'Unordered Collection';
$_lang['varnishpurge.rescode_426'] = 'Upgrade Required';
$_lang['varnishpurge.rescode_449'] = 'Retry With';
$_lang['varnishpurge.rescode_450'] = 'Blocked by Windows Parental Controls';
$_lang['varnishpurge.rescode_500'] = 'Internal Server Error';
$_lang['varnishpurge.rescode_501'] = 'Not Implemented';
$_lang['varnishpurge.rescode_502'] = 'Bad Gateway';
$_lang['varnishpurge.rescode_503'] = 'Service Unavailable';
$_lang['varnishpurge.rescode_504'] = 'Gateway Timeout';
$_lang['varnishpurge.rescode_505'] = 'HTTP Version Not Supported';
$_lang['varnishpurge.rescode_506'] = 'Variant Also Negotiates';
$_lang['varnishpurge.rescode_507'] = 'Insufficient Storage';
$_lang['varnishpurge.rescode_509'] = 'Bandwidth Limit Exceeded';
$_lang['varnishpurge.rescode_510'] = 'Not Extended'

