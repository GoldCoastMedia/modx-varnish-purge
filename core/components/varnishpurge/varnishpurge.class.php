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

	public $site    = NULL;
	public $setting = array();
	public $modx;

	private $_debug = FALSE;
	private $_namespace = 'varnishpurge.';

	public function __construct(modX &$modx)
	{
		$this->modx =& $modx;
		$this->modx->lexicon->load('varnishpurge:default');

		$settings = $this->modx->newQuery('modSystemSetting')->where(
			array('key:LIKE' => $this->_namespace . '%')
		);

		$settings = $this->modx->getCollection('modSystemSetting', $settings);
		
		foreach($settings as $key => $setting) {
			$key = str_replace($this->_namespace, '', $key);
			
			$this->setting[$key] = $setting->get('value');
		}
	}

	/**
	 * Send a purge request via cURL
	 *
	 * @param   array  $urls     A list of URLs to purge
	 * @param   string $method   HTTP request method
	 * @param   int    $timeout  Connection timeout
	 * @param   bool   $debug    Debug boolean
	 * @return  void
	 */
	public function purge($urls = array(), $method = 'curl', $timeout = 10, $debug = FALSE)
	{
		$method  = strtolower($this->setting['method']);
		$timeout = $this->setting['timeout'];
		$debug   = $this->setting['debug'];

		// Send requests via cURL
		if($method === 'curl' AND is_callable('curl_init') )
		{
			foreach($urls as $url)
			{
				$url = trim($this->form_url($url));

				$req = curl_init(trim($url));
				curl_setopt($req, CURLOPT_CUSTOMREQUEST, 'PURGE');
				curl_setopt($req, CURLOPT_CONNECTTIMEOUT, $timeout);
				curl_setopt($req, CURLOPT_RETURNTRANSFER, TRUE);
				curl_exec($req);

				$status = curl_getinfo($req, CURLINFO_HTTP_CODE);

				if($status)
				{
					if($debug)
						$this->debug($url, $status);

					$this->debug($url, $status, FALSE);
				}
			}
		}
		// Send requests via file_get_contents
		elseif($method === 'file_get_contents' AND is_callable('file_get_contents') )
		{
			foreach($urls as $url)
			{
				$url = trim($this->form_url($url));

				$context = stream_context_create(array(
					'http' => array(
						'method'  => 'PURGE',
						'timeout' => $timeout
						),
					)
				);

				file_get_contents($url, FALSE, $context);

				$status = sscanf($http_response_header[0], 'HTTP/%*d.%*d %d');

				if($http_response_header)
				{
					if($debug)
						$this->debug($url, $status[0]);

					$this->debug($url, $status[0], FALSE);
				}
			}
		}
		else
		{
			$msg = $this->modx->lexicon('varnishpurge.invalid_method', array('method' => $method));
			$this->modx->log(modX::LOG_LEVEL_ERROR, $msg);
		}
	}

	/**
	 * Debug and log purge responses
	 *
	 * @param   string  $url     The purge URL
	 * @param   int     $status  The purge response code
	 * @param   bool    $log     Send to the MODX log
	 * @return  void
	 */
	protected function debug($url, $status, $log = TRUE)
	{
		if($status === 200)
		{
			$msg = $this->modx->lexicon('varnishpurge.purge_success', array('url' => $url));
			
			if($log)
				$this->modx->log(modX::LOG_LEVEL_INFO, $msg);

			$this->modx->error->success($msg);
		}
		else
		{
			$msg = $this->modx->lexicon('varnishpurge.purge_fail', array(
				'url'      => $url,
				'code'     => $status,
				'response' => $this->modx->lexicon('varnishpurge.rescode_' . $status),
			));
			
			if($log)
				$this->modx->log(modX::LOG_LEVEL_DEBUG, $msg);
			
			$this->modx->error->failure($msg);
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
