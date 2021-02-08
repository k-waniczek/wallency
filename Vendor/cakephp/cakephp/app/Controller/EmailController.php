<?php
App::uses("AppController", "Controller");

class EmailController extends AppController {
    public function myview($uuid) {
        $this->set("uuid", $uuid);
    }
}
