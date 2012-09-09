<?php
/**
 * Varnish Purge
 *
 * Copyright (c) 2012 Gold Coast Media Ltd
 *
 * This file is part of Varnish Purge for MODx.
 *
 * Varnish Purge is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * Varnish Purge is distributed in the hope that it will be useful, but 
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or 
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Varnish Purge if not, write to the Free Software Foundation, Inc., 59 
 * Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package  varnishpurge
 * @author   Dan Gibbs <dan@goldcoastmedia.co.uk>
 */
 
require_once $modx->getOption('core_path') . 'components/varnishpurge/varnishpurge.class.php';

$doc = $_REQUEST; // FIXME: Use a better way?
$event = $modx->event->name;
$enabled = $vp->setting['enabled'];
$vp = new VarnishPurge($modx);

// Document has been changed and saved
if($enabled AND $event == 'OnDocFormSave')
{
	if($doc['published'])
		$vp->purge(array($modx->makeUrl($doc['id'])));
}

// Entire cache has been refreshed
if($enabled AND $event == 'OnSiteRefresh')
{
	$urls = explode(',', $setting['domains']);

	if( !is_array($urls))
	{
		$urls = array($modx->makeUrl(1));
	}

	$vp->purge($urls);
}
