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
$vp = new VarnishPurge($modx);

$doc = $_REQUEST; // FIXME: Use a better way?
$event = $modx->event->name;
$enabled = $vp->setting['enabled'];

// Document has been changed and saved
if($enabled AND $event == 'OnDocFormSave' AND $vp->setting['purge_document'])
{
	$vp->site = MODX_SITE_URL;
	
	if($doc['published']) {
		
		$document = $modx->getObject('modResource', $doc['id']);
		$context = $document->get('context_key');
		$modx->switchContext($context);
		$modx->reloadContext($context);

		$vp->purge(array(
			$modx->makeUrl($doc['id'], '', '', 'full'),
		));

		$modx->switchContext('mgr'); // NOTE: Unnecessary?
	}
}

// Entire cache has been refreshed
if($enabled AND $event == 'OnSiteRefresh' AND $vp->setting['purge_website'])
{
	$urls = explode(',', $vp->setting['domains']);

	if( !is_array($urls))
	{
		$urls = array(MODX_SITE_URL);
	}

	$vp->purge($urls);
}

// Remove static file after file manager transaction
if($enabled AND ( $event == 'OnFileManagerDirRemove' 
	OR $event == 'OnFileManagerFileRemove'
	OR $event == 'OnFileManagerFileUpdate'
	OR $event == 'OnFileManagerMoveObject'
	)  )
{
	
	/* TODO: Can't bind to OnFileManagerFileRename and OnFileManagerDirRename because only newPath is delivered
	and we need the old path to clean cache.
	*/

	// OnFileManagerDirRemove
	if(isset($directory) && !empty($directory)) $url = $directory;

	// OnFileManagerFileRemove AND OnFileManagerFileUpdate
	if(isset($path) && !empty($path)) $url = $path;

	// OnFileManagerMoveObject
	if(isset($from) && !empty($from)) $url = $from;

	if(isset($url) && !empty($url)) {

		$url = str_replace(MODX_BASE_PATH, MODX_SITE_URL, $url);

		$vp->purge(array($url));

	}

}
