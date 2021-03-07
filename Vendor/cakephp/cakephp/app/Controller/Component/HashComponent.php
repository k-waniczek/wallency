<?php

App::uses("Component", "Controller");

class HashComponent extends Component {
    public function hash($password) {

        $hash_algos = ["sha1", "sha224", "sha256", "sha384", "sha512"];
        for($i = 0; $i < count($hash_algos); $i++) {
            $password = hash($hash_algos[$i], $password);
        }
        return $password;
    }
}

?>