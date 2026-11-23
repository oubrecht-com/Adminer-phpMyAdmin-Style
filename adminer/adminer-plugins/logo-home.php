<?php

/** Logo vlevo nahore vede misto na adminer.org na tento Adminer:
* po prihlaseni na uvodni stranku aktualniho serveru, jinak na prihlasovaci stranku.
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class AdminerLogoHome extends Adminer\Plugin {
	function head($dark = null) {
		$base = preg_replace('~\?.*~', '', Adminer\ME);
		$home = (isset($_GET["username"])
			? substr(preg_replace('~\b(db|ns)=[^&]*&~', '', Adminer\ME), 0, -1)
			: $base);
		echo Adminer\script("document.addEventListener('DOMContentLoaded', function () {
	var logo = document.getElementById('h1');
	if (!logo) return;
	logo.href = '" . Adminer\js_escape($home) . "';
	logo.removeAttribute('target');
	logo.removeAttribute('rel');
	logo.title = 'Úvodní stránka';
});");
		return null;
	}

	protected $translations = array(
		'cs' => array('' => 'Logo vede na úvodní stránku tohoto Admineru místo na adminer.org'),
	);
}
