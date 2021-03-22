<?php
App::uses("Controller", "Controller");

class AppController extends Controller {
    public function beforeFilter() {
        Configure::write("Config.language", $this->Session->read("language"));
        $locale = $this->Session->read("language");
        if ($locale && file_exists(APP . "View" . DS . $locale . DS . $this->viewPath . DS . $this->view . $this->ext)) {
            $this->viewPath = $locale . DS . $this->viewPath;
        }
    }
}
