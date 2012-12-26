<?php

namespace Core\Command;

/**
 * Generate Hash Secret Command
 * @author Evan Byrne
 */
class Generate_Hash_Secret {
	
	/**
	 * Help
	 */
	public function help() {

		echo "\ngenerate_hash_secret <config>\n\n";
		echo "Description:\n";
		echo "\tCreates a random string and sets it to 'hash_secret'\n" .
			"\tconfiguration option, which is used for hashing passwords.\n\n";
		echo "Warning:\n" .
			"\tThis will overwrite the application/config/<config>/hash.php\n" .
			"\tfile.\n\n";

	}

	/**
	 * Run
	 * @param string Configuration
	 */
	public function run($config) {
		
		echo "Generating new hash secret...\n";
		
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789=-_`~!@#$%^&*(){}[]|:;,./?';
		$chars_len = strlen($chars) - 1;
		$secret = '';

		for($i = 0; $i < 50; $i++) {

			$secret .= substr($chars, mt_rand(0, $chars_len), 1);

		}

		$f = fopen(APPLICATION . "/config/$config/hash.php", 'w');
		fwrite($f, "<?php\n\n" .
			"namespace Core;\n\n" .
			"Config::set('hash_secret', '$secret');");
		fclose($f);
		
	}
	
}