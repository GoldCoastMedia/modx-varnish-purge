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
    'value' => '',
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
    'value' => 5,
    'xtype' => 'textfield',
    'namespace' => 'varnishpurge',
    'area' => 'Caching',
), '', true, true);

$settings['setting_varnishpurge.method']= $modx->newObject('modSystemSetting');
$settings['setting_varnishpurge.method']->fromArray(array (
    'key' => 'varnishpurge.method',
    'description' => 'setting_varnishpurge.method_desc',
    'value' => 'curl',
    'xtype' => 'textfield',
    'namespace' => 'varnishpurge',
    'area' => 'Caching',
), '', true, true);


$settings['setting_varnishpurge.purge_document']= $modx->newObject('modSystemSetting');
$settings['setting_varnishpurge.purge_document']->fromArray(array (
    'key' => 'varnishpurge.purge_document',
    'description' => 'setting_varnishpurge.purge_document_desc',
    'value' => 1,
    'xtype' => 'combo-boolean',
    'namespace' => 'varnishpurge',
    'area' => 'Caching',
), '', true, true);

$settings['setting_varnishpurge.purge_website']= $modx->newObject('modSystemSetting');
$settings['setting_varnishpurge.purge_website']->fromArray(array (
    'key' => 'varnishpurge.purge_website',
    'description' => 'setting_varnishpurge.purge_website_desc',
    'value' => 1,
    'xtype' => 'combo-boolean',
    'namespace' => 'varnishpurge',
    'area' => 'Caching',
), '', true, true);

return $settings;
