<?php

/**
* ownCloud - App Template plugin
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

require_once("../../lib/controller.php");
require_once("../../lib/response.php");
require_once("../../lib/request.php");

require_once("../mocks/api.mock.php");

require_once("../../controllers/ajax.controller.php");


class AjaxControllerTest extends PHPUnit_Framework_TestCase {


	public function testSetSystemValue(){
		$post = array('somesetting' => 'this is a test');
		$request = new \OCA\AppTemplateAdvanced\Request(null, $post);
		$api = new APIMock();

		$controller = new \OCA\AppTemplateAdvanced\AjaxController($api, $request);
		$controller->setSystemValue();

		$this->assertEquals($post['somesetting'], $api->setSystemValueData['somesetting']);
	}


}

