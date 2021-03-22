<?php

App::uses("Component", "Controller");

class ValidateEmailComponent extends Component {
    public function validate($email) {

        $emailValid = false;

		try {
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$emailDomain = explode("@", $email);
				if(isset(dns_get_record($emailDomain[1], DNS_MX)[0]["target"])) {
					if (filter_var(gethostbyname(dns_get_record($emailDomain[1], DNS_MX)[0]["target"]), FILTER_VALIDATE_IP)) {
						$emailValid = true;
					}
				}
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}

        return $emailValid;
    }
}

?>