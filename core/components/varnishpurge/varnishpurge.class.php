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

class VarnishPurge {
	public $setting = array();
	
	protected $_modx = NULL;
	protected $_debug = FALSE;
	protected $_namespace = 'varnishpurge.';

	public function __construct(modX &$modx)
	{
		$this->modx =& $modx;
		
		$this->setting = array(
			'debug'   => $modx->getOption($this->_namespace . 'debug'),
			'enabled' => $modx->getOption($this->_namespace . 'enabled'),
			'domains' => $modx->getOption($this->_namespace . 'domains'),
			'timeout' => $modx->getOption($this->_namespace . 'timeout'),
		);
	}

	public function purge($urls = array(), $timeout = 10, $debug = FALSE)
	{
		$debug = $this->setting['debug'];
		$timeout = $this->setting['timeout'];

		foreach($urls as $url)
		{
			$req = curl_init($url);
			curl_setopt($req, CURLOPT_CUSTOMREQUEST, 'PURGE');
			curl_setopt($req, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt($req, CURLOPT_RETURNTRANSFER, TRUE);
			curl_exec($req);
			$status = curl_getinfo($req, CURLINFO_HTTP_CODE);
		
			if($debug)
				$this->debug($url, $status);
		}
	}

	public function debug($url, $status)
	{
		$this->modx->setLogLevel(modX::LOG_LEVEL_DEBUG);

		if($status === 200)
		{
			$msg = $modx->lexicon('varnishpurge.purge_success', array('url' => $url));
			$this->modx->log(modX::LOG_LEVEL_DEBUG, $msg);
		}
		else
		{
			$msg = $modx->lexicon('varnishpurge.purge_fail', array('url' => $url, 'code' => $status));
			$this->modx->log(modX::LOG_LEVEL_DEBUG, $msg);
		}
	}
}
