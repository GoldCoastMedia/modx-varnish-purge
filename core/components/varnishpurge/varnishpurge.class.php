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
	public $site = NULL;
	public $setting = array();
	
	protected $_modx = NULL;
	protected $_debug = FALSE;
	protected $_namespace = 'varnishpurge.';

	public function __construct(modX &$modx)
	{
		$this->modx =& $modx;
		$this->modx->lexicon->load('varnishpurge:default');

		$this->setting = array(
			'debug'   => $modx->getOption($this->_namespace . 'debug'),
			'enabled' => $modx->getOption($this->_namespace . 'enabled'),
			'domains' => $modx->getOption($this->_namespace . 'domains'),
			'timeout' => $modx->getOption($this->_namespace . 'timeout'),
		);
	}

	/**
	 * Send a purge request via cURL
	 *
	 * @param   array  $urls     A list of URLs to purge
	 * @param   int    $timeout  Connection timeout
	 * @param   bool   $debug    Debug boolean
	 * @return  void
	 */
	public function purge($urls = array(), $timeout = 10, $debug = FALSE)
	{
		$debug = $this->setting['debug'];
		$timeout = $this->setting['timeout'];

		foreach($urls as $url)
		{
			$url = $this->form_url($url);
			
			$req = curl_init(trim($url));
			curl_setopt($req, CURLOPT_CUSTOMREQUEST, 'PURGE');
			curl_setopt($req, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt($req, CURLOPT_RETURNTRANSFER, TRUE);
			curl_exec($req);
			$status = curl_getinfo($req, CURLINFO_HTTP_CODE);

			if($debug)
				$this->debug($url, $status);
		}
	}

	/**
	 * Debug and log purge responses
	 *
	 * @param   string  $url     The purge URL
	 * @param   int     $status  The purge response code
	 * @return  void
	 */
	protected function debug($url, $status)
	{
		$this->modx->setLogLevel(modX::LOG_LEVEL_DEBUG);

		if($status === 200)
		{
			$msg = $this->modx->lexicon('varnishpurge.purge_success', array('url' => $url));
			$this->modx->log(modX::LOG_LEVEL_DEBUG, $msg);
		}
		else
		{
			$msg = $this->modx->lexicon('varnishpurge.purge_fail', array(
				'url'      => $url,
				'code'     => $status,
				'response' => $this->modx->lexicon('varnishpurge.rescode_' . $status),
			));
			$this->modx->log(modX::LOG_LEVEL_DEBUG, $msg);
		}
	}
	
	/**
	 * Check a hostname is in use. TODO: Improve this
	 *
	 * @param   string  $url  The purge URL
	 * @return  string  $url  A formed URL
	 */
	protected function form_url($url = NULL)
	{
		$host = FALSE;
		
		if($parsed = parse_url($url))
		{
			if($parsed['host'])
				$host = TRUE;
		}
		
		return $url = ($host) ? $url : $this->site. '/' . $url;
	}
}
