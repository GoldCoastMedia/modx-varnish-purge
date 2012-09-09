<?php
$settings = array();

$settings['setting_varnishpurge.debug']= $modx->newObject('modSystemSetting');
$settings['setting_varnishpurge.debug']->fromArray(array (
    'key' => 'varnishpurge.debug',
    'description' => 'setting_varnishpurge.debug_desc',
    'value' => 0,
    'xtype' => 'combo-boolean',
    'namespace' => 'varnishpurge',
    'area' => 'Caching',
), '', true, true);

$settings['setting_varnishpurge.domains']= $modx->newObject('modSystemSetting');
$settings['setting_varnishpurge.domains']->fromArray(array (
    'key' => 'varnishpurge.domains',
    'description' => 'setting_varnishpurge.domains_desc',
    'value' => 1,
    'xtype' => 'textarea',
    'namespace' => 'varnishpurge',
    'area' => 'Caching',
), '', true, true);

$settings['setting_varnishpurge.enabled']= $modx->newObject('modSystemSetting');
$settings['setting_varnishpurge.enabled']->fromArray(array (
    'key' => 'varnishpurge.enabled',
    'description' => 'setting_varnishpurge.enabled_desc',
    'value' => 1,
    'xtype' => 'combo-boolean',
    'namespace' => 'varnishpurge',
    'area' => 'Caching',
), '', true, true);

$settings['setting_varnishpurge.timeout']= $modx->newObject('modSystemSetting');
$settings['setting_varnishpurge.timeout']->fromArray(array (
    'key' => 'varnishpurge.timeout',
    'description' => 'setting_varnishpurge.timeout_desc',
    'value' => 1,
    'xtype' => 'textfield',
    'namespace' => 'varnishpurge',
    'area' => 'Caching',
), '', true, true);

return $settings;
