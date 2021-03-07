<?php
App::uses("Controller", "Controller");

class AppController extends Controller {
    public function beforeFilter() {
        Configure::write("Config.language", $this->Session->read("language"));
        $locale = $this->Session->read("language");
        if ($locale && file_exists(APP . "View" . DS . $locale . DS . $this->viewPath . DS . $this->view . $this->ext)) {
            // e.g. use /app/View/fra/Pages/tos.ctp instead of /app/View/Pages/tos.ctp
            $this->viewPath = $locale . DS . $this->viewPath;
        }
    }
}
