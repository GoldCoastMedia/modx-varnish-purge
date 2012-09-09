<?php
/**
 * Resolver script 
 */

/* The $modx object is not available here. In its place we
 * use $object->xpdo
 */

$modx =& $object->xpdo;

$pluginEvents = array('OnDocFormSave', 'OnSiteRefresh');
$plugins = array('VarnishPurge');
$category = 'VarnishPurge';

$hasPlugins = TRUE;
$hasTemplates = FALSE;
$hasTemplateVariables = FALSE;

$hasExistingSettings = FALSE;

/* set to true to connect property sets to elements */
$connectPropertySets = true;


$success = true;

$modx->log(xPDO::LOG_LEVEL_INFO,'Running PHP Resolver.');
switch($options[xPDOTransport::PACKAGE_ACTION]) {
    /* This code will execute during an install */
    case xPDOTransport::ACTION_INSTALL:
        /* Assign plugins to System events */
        if ($hasPlugins) {
            foreach($plugins as $k => $plugin) {
                $pluginObj = $modx->getObject('modPlugin',array('name'=>$plugin));
                if (! $pluginObj) $modx->log(xPDO::LOG_LEVEL_INFO,'cannot get object: ' . $plugin);
                if (empty($pluginEvents)) $modx->log(xPDO::LOG_LEVEL_INFO,'Cannot get System Events');
                if (!empty ($pluginEvents) && $pluginObj) {

                    $modx->log(xPDO::LOG_LEVEL_INFO,'Assigning Events to Plugin ' . $plugin);

                    foreach($pluginEvents as $k => $event) {
                        $intersect = $modx->newObject('modPluginEvent');
                        $intersect->set('event',$event);
                        $intersect->set('pluginid',$pluginObj->get('id'));
                        $intersect->save();
                    }
                }
            }
        }
        /* Connect TVs to Templates. It's assumed that all TVs
         * will be connected to all package templates. If you
         * want to connect different TVs to different templates
         * you need to rewrite this.
         */

        if ($hasTemplates && $hasTemplateVariables) {
            $categoryObj = $modx->getObject('modCategory',array('category'=> $category));
            if (! $categoryObj) {
                $modx->log(xPDO::LOG_LEVEL_INFO,'Coult not retrieve category object: ' . $category);
            } else {
                $categoryId = $categoryObj->get('id');
            }

            $modx->log(xPDO::LOG_LEVEL_INFO,'Attempting to attach TVs to Templates');
            $ok = true;
            $templates = $modx->getCollection('modTemplate', array('category'=> $categoryId));
            if (!empty($templates)) {

                $tvs = $modx->getCollection('modTemplateVar', array('category'=> $categoryId));

                if (!empty($tvs)) {
                    foreach ($templates as $template) {
                        foreach($tvs as $tv) {
                            $tvt = $modx->newObject('modTemplateVarTemplate');
                            if ($tvt) {
                                $r1 = $tvt->set('templateid', $template->get('id'));
                                $r2 = $tvt->set('tmplvarid', $tv->get('id'));
                                if ($r1 && $r2) {
                                    $tvt->save();
                                } else {
                                    $ok = false;
                                    $modx->log(xPDO::LOG_LEVEL_INFO,'Could not set TemplateVarTemplate fields');
                                }
                            } else {
                                $ok = false;
                                $modx->log(xPDO::LOG_LEVEL_INFO,'Could not create TemplateVarTemplate');
                            }
                        }
                    }
                } else {
                    $ok = false;
                    $modx->log(xPDO::LOG_LEVEL_INFO,'Could not retrieve TVs in category: ' . $category);
                }

            } else {
                $ok = false;
                $modx->log(xPDO::LOG_LEVEL_INFO,'Could not retrieve Templates in category: ' . $category);
            }

            if ($ok) {
                $modx->log(xPDO::LOG_LEVEL_INFO,'TVs attached to Templates successfully');
            } else {
                $modx->log(xPDO::LOG_LEVEL_INFO,'Failed to attach TVs to Templates');
            }
        }
        /* This section will set the site_name system setting based on the checkbox and
         * input field in the user.input.php form presented during the install.
         */
        $setSiteName = $modx->getOption('change_sitename', $options, false);
        if ($setSiteName) {
            $siteName = $modx->getOption('sitename', $options);
            $modx->log(xPDO::LOG_LEVEL_INFO,'Setting site name to: ' . $siteName);
            $setting = $modx->getObject('modSystemSetting','site_name');
            $setting->set('value', $siteName);
            $setting->save();
        }

        /* This section will set any system settings in the variables at the top of this file. */
        if ($hasExistingSettings) {
            $modx->log(xPDO::LOG_LEVEL_INFO,'Attempting so set existing System Settings');
            foreach($settings as $key=>$value) {
                $setting = $modx->getObject('modSystemSetting',array('key'=>$key));
                if ($setting) {
                    $setting->set('value',$value);
                    if ($setting->save()){
                        $value = $value? $value : '0'; /* make false values show in msg */
                        $modx->log(xPDO::LOG_LEVEL_INFO,'Updated System Setting: ' . $key . ' to ' . $value );
                    }
                } else {
                    $modx->log(xPDO::LOG_LEVEL_INFO,'Could not retrieve setting: ' . $key);
                }
            }
        }
        /* This section connects MyPropertySet1 to MySnippet1.
         * You'll have to modify the code to meet your needs.
         *
         * Note that if you want to connect a bunch of property sets to a bunch of
         * elements, since all elements and property sets are in our category
         * we could get the category ID and then get the objects with two
         * $modx->getCollection() calls and put the code below in a double foreach loop.
         *
         * For example, to connect all our property sets to all our snippets, we'd do this:
         *
         * $category = $modx->getObject('modCategory', array('category','MyComponent'));
         * $cId = $category->get('id');
         * $snippets = $modx->getCollection('modSnippet',array('category'=>$cId));
         * $propertySets = $modx->getCollection('modPropertySet',array('category'=>$cId));
         * foreach($snippets as $snippet) {
         *     foreach($propertySets as $propertySet {
         *         $intersect = $modx->newObject('modElementPropertySet');
         *         $intersect->set('element',$snippet->get('id'));
         *         $intersect->set('element_class','modSnippet');
         *         $intersect->set('property_set',$propertySet->get('id'));
         *         $intersect->save();
         *     }
         * }
         *
         */
         /*$snippetName = 'MySnippet1';
         $propertySetName = 'MyPropertySet1';
         $snippet = $modx->getObject('modSnippet', array('name'=>$snippetName));
         if ($snippet) {
             $propertySet = $modx->getObject('modPropertySet',array('name'=>$propertySetName));
             if ($propertySet) {
                 $intersect = $modx->newObject('modElementPropertySet');
                 $intersect->set('element',$snippet->get('id'));
                 $intersect->set('element_class','modSnippet');
                 $intersect->set('property_set',$propertySet->get('id'));
                 if ($intersect->save()) {
                     $modx->log(xPDO::LOG_LEVEL_INFO,'Connected snippet ' . $snippetName .  ' to property set ' . $propertySetName);
                 } else {
                     $modx->log(xPDO::LOG_LEVEL_INFO,'Failed to connect snippet ' . $snippetName .  ' to property set ' . $propertySetName);
                 }

             } else {
                 $modx->log(xPDO::LOG_LEVEL_INFO,'Could not retrieve property set: ' . $propertySetName);
             }

         } else {
                 $modx->log(xPDO::LOG_LEVEL_INFO,'Could not retrieve snippet: ' . $snippetName);
         }*/

        break;

    /* This code will execute during an upgrade */
    case xPDOTransport::ACTION_UPGRADE:

        /* put any upgrade tasks (if any) here such as removing
           obsolete files, settings, elements, resources, etc.
        */

        $success = true;
        break;

    /* This code will execute during an uninstall */
    case xPDOTransport::ACTION_UNINSTALL:
        $modx->log(xPDO::LOG_LEVEL_INFO,'Uninstalling . . .');
        $success = true;
        break;

}
$modx->log(xPDO::LOG_LEVEL_INFO,'Script resolver actions completed');
return $success;
