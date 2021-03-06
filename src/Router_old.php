<?php

namespace Edily\Base;

/**
 * Description of router
 *
 * @author edily
 */
class Router
{

    public $controller;
    public $action;
    public $params;
    protected $requestItens;
    private $argv;

    public function __construct($argv = null)
    {
        $this->argv = $argv;
        $this->prepareUri();
        $this->getController();
        $this->getAction();

        //echo "<p>Controller: " . $this->controller . "</p>";
        //echo "<p>Action: " . $this->action . "</p>"; 
        //foreach ($this->params as $key => $value) {
        //	echo "<p>Param: " . $key . " = " . $value . "</p>";
        //}    

        Register::set('route', $this);
    }

    private function getQueryString()
    {
        return isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
    }

    private function getController()
    {
        if (isset($this->argv[1])) {
            $this->controller = $this->argv[1];
            return;
        }
        $this->controller = !empty($this->requestItens[0]) ? $this->requestItens[0] : "Index";
    }

    private function getAction()
    {
        if (isset($this->argv[2])) {
            $this->action = $this->argv[2];
            return;
        }
        $this->action = isset($this->requestItens[1]) ? $this->requestItens[1] : "index";
    }

    private function prepareUri()
    {
        if(!empty($this->argv)){
            $this->prepareParamsFromCommandLine();
            return;
        }
        
        $uriAP = $this->getAfterPublic();
        $this->splitRequest($uriAP);
        $this->prepareParams();
    }
    
    private function getAfterPublic()
    {
        $pathArr = explode("=", $this->getQueryString());
        return isset($pathArr[1]) ? $pathArr[1] : '';
    }

    private function splitRequest($uriAP)
    {
        $this->requestItens = explode("/", $uriAP);
    }

    private function prepareParams()
    {
        $var = $val = "";
        foreach ($this->requestItens as $key => $value) {
            if ($key > 1) {
                if (($key % 2) == 0) {
                    $var = $value;
                } else {
                    $val = $value;
                }
                $this->params[$var] = $val;
            }
        }
    }
    
    private function prepareParamsFromCommandLine()
    {
        $var = $val = "";
        $this->requestItens = $this->argv;
        foreach ($this->requestItens as $key => $value) {
            if ($key > 2) {
                if (($key % 2) == 0) {
                    $val = $value;
                } else {
                    $var = $value;
                }
                $this->params[$var] = $val;
            }
        }
    }

}
