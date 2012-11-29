<?php

/**
* ownCloud - App Template Example
*
* @author Bernhard Posselt
* @copyright 2012 Bernhard Posselt nukeawhale@gmail.com 
*
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
* License as published by the Free Software Foundation; either
* version 3 of the License, or any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU AFFERO GENERAL PUBLIC LICENSE for more details.
*
* You should have received a copy of the GNU Affero General Public
* License along with this library.  If not, see <http://www.gnu.org/licenses/>.
*
*/

namespace OCA\AppTemplateAdvanced;

/**
 * Declare your classes and their include path so that they'll be automatically
 * loaded once you instantiate them
 */
\OC::$CLASSPATH['Pimple'] = 'apps/apptemplate_advanced/3rdparty/Pimple/Pimple.php';

\OC::$CLASSPATH['OCA\AppTemplateAdvanced\API'] = 'apps/apptemplate_advanced/lib/api.php';
\OC::$CLASSPATH['OCA\AppTemplateAdvanced\Request'] = 'apps/apptemplate_advanced/lib/request.php';
\OC::$CLASSPATH['OCA\AppTemplateAdvanced\Security'] = 'apps/apptemplate_advanced/lib/security.php';
\OC::$CLASSPATH['OCA\AppTemplateAdvanced\Controller'] = 'apps/apptemplate_advanced/lib/controller.php';
\OC::$CLASSPATH['OCA\AppTemplateAdvanced\TemplateResponse'] = 'apps/apptemplate_advanced/lib/response.php';
\OC::$CLASSPATH['OCA\AppTemplateAdvanced\JSONResponse'] = 'apps/apptemplate_advanced/lib/response.php';

\OC::$CLASSPATH['OCA\AppTemplateAdvanced\IndexController'] = 'apps/apptemplate_advanced/controllers/index.controller.php';
\OC::$CLASSPATH['OCA\AppTemplateAdvanced\SettingsController'] = 'apps/apptemplate_advanced/controllers/settings.controller.php';
\OC::$CLASSPATH['OCA\AppTemplateAdvanced\AjaxController'] = 'apps/apptemplate_advanced/controllers/ajax.controller.php';


/**
 * @return a new DI container with prefilled values for the news app
 */
function createDIContainer(){
	$container = new \Pimple();

	/** 
	 * BASE
	 */
	$container['API'] = $container->share(function($c){
		return new API('apptemplate_advanced');
	});

	$container['Security'] = $container->share(function($c){
		return new Security($c['API']->getAppName());
	});

	$container['Request'] = $container->share(function($c){
                return new Request($_GET, $_POST, $_FILES);
	});


	/** 
	 * CONTROLLERS
	 */
	$container['IndexController'] = function($c){
		return new IndexController($c['API'], $c['Request']);
	};

	$container['SettingsController'] = function($c){
		return new SettingsController($c['API'], $c['Request']);
	};


	$container['AjaxController'] = function($c){
		return new AjaxController($c['API'], $c['Request']);
	};


	return $container;
}