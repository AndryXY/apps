<?php
/**
* ownCloud - News app
*
* @author Bernhard Posselt
* Copyright (c) 2012 - Bernhard Posselt <nukeawhale@gmail.com>
*
* This file is licensed under the Affero General Public License version 3 or later.
* See the COPYING-README file
*
*/


namespace OCA\News;

class Controller {

    protected $trans;
    private $safeParams;

    public function __construct(){
        $this->trans = \OC_L10N::get('news');
        $this->safeParams = array();
    }


    protected function addScript($name){
        \OCP\Util::addScript('news', $name);
    }


    protected function addStyle($name){
        \OCP\Util::addStyle('news', $name);
    }


    protected function add3rdPartyScript($name){
        \OCP\Util::addScript('news/3rdparty', $name);
    }


    protected function add3rdPartyStyle($name){
        \OCP\Util::addStyle('news/3rdparty', $name);
    }


    /**
     * Shortcut for setting a user defined value
     * @param $key the key under which the value is being stored
     * @param $value the value that you want to store
     */
    protected function setUserValue($key, $value){
        \OCP\Config::setUserValue($this->userId, 'news', $key, $value);
    }


    /**
     * Shortcut for getting a user defined value
     * @param $key the key under which the value is being stored
     */
    protected function getUserValue($key){
        return \OCP\Config::getUserValue($this->userId, 'news', $key);
    }


    /**
     * Renders a renderer and sets the csrf check and logged in check to true
     * @param Renderer $renderer: the render which should be used to render the page
     */
    protected function render(Renderer $renderer){
        $renderer->render();
    }


    /**
     * Binds variables to the template and prints it
     * @param $templateName the name of the template
     * @param $arguments an array with arguments in $templateVar => $content
     * @param $safeParams template parameters which should not be escaped
     * @param $fullPage if true, it will render a full page, otherwise only a part
     *                  defaults to true
     */
    protected function renderTemplate($templateName, $arguments=array(), 
                                      $safeParams=array(), $fullPage=true){
        $renderer = new TemplateRenderer($templateName, $fullPage);
        $renderer->bind($arguments);
        $renderer->bindSafe($safeParams);
        $this->render($renderer);
    }

    /**
     * Binds variables to a JSON array and prints it
     * @param $arguments an array with arguments in $key => $value
     * @param $error: Empty by default. If set, a log message written and the
     *                $error will be sent to the client
     */
    protected function renderJSON($arguments=array(), $error=""){
        $renderer = new JSONRenderer($error);
        $renderer->bind($arguments);
        $this->render($renderer);
    }


}


/**
 * Renderers
 */
interface Renderer {
    public function render();
    public function bind($params);
}


/**
 * Used to render a normal template
 */
class TemplateRenderer implements Renderer {

    private $safeParams = array();
    private $template;

    /**
     * @param string $name: the template which we want to render
     * @param $fullPage: if the page should be included into the standard page
     */
    public function __construct($name, $fullPage=true){
        if($fullPage){
            $this->template = new \OCP\Template('news', $name, 'user');
        } else {
            $this->template = new \OCP\Template('news', $name);
        }
    }


    /**
     * @brief binds parameters to the renderer which shouldnt be escaped
     * @param array $params: an array of the form $doNotEscape => true
     */
    public function bindSafe($params){
        $this->safeParams = $params;
    }


    /**
     * Bind parameters to the template
     * @param array $params: an array of the form $key => value which will be used
     *                       for access in templates
     */
    public function bind($params){
        foreach($params as $key => $value){
            if(array_key_exists($key, $this->safeParams)) {
                $this->template->assign($key, $value, false);
            } else {
                $this->template->assign($key, $value);
            }
        }
    }


    /**
     * Print the page
     */
    public function render(){
        $this->template->printPage();
    }


}



/**
 * Use this to render JSON calls
 */
class JSONRenderer implements Renderer {

    private $params;

    /**
     * @param string $error: if empty a success is sent, otherwise an error message
     *                       will be logged
     */
    public function __construct($error){
        $this->error = $error;
    }


    /**
     * Bind parameters to the template
     * @param array $params: an array which will be converted to JSON
     */
    public function bind($params){
        $this->params = $params;
    }


    /**
     * Print the json array
     */
    public function render(){
        if($this->error === ""){
            OCP\JSON::success($this->params);        
        } else {
            OCP\JSON::error(array(
                                'data' => array('message' => $l->t('An error occured: ') . $error)
                            )
            );
            OCP\Util::writeLog('news',$_SERVER['REQUEST_URI'] . 'Error: '. $error, OCP\Util::ERROR);
            exit();
        }
        
    }

    
}