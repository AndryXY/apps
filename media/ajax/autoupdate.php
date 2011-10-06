<?php

/**
* ownCloud - media plugin
*
* @author Robin Appelman
* @copyright 2010 Robin Appelman icewind1991@gmail.com
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
* You should have received a copy of the GNU Lesser General Public 
* License along with this library.  If not, see <http://www.gnu.org/licenses/>.
* 
*/

header('Content-type: text/html; charset=UTF-8') ;

//no apps or filesystem
$RUNTIME_NOAPPS=true;
$RUNTIME_NOSETUPFS=true;

require_once('../../../lib/base.php');
OC_JSON::checkAppEnabled('media');

if(defined("DEBUG") && DEBUG) {error_log($_GET['autoupdate']);}
$autoUpdate=(isset($_GET['autoupdate']) and $_GET['autoupdate']=='true');
if(defined("DEBUG") && DEBUG) {error_log((integer)$autoUpdate);}

OC_Preferences::setValue(OC_User::getUser(),'media','autoupdate',(integer)$autoUpdate);

OC_JSON::success(array('data' => $autoUpdate));
?>
