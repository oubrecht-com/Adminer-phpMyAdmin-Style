<?php

/** Prvni odkaz v horni navigaci (nazev systemu, napr. "MariaDB") po potvrzeni
* odhlasi ze serveru - stejne jako tlacitko "Odhlasit".
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class AdminerBreadcrumbConfirm extends Adminer\Plugin {
	function head($dark = null) {
		echo Adminer\script("document.addEventListener('DOMContentLoaded', function () {
	var link = document.querySelector('#breadcrumb > a');
	var logout = document.getElementById('logout');
	if (!link || !logout) return;
	link.title = 'Odhlásit';
	link.addEventListener('click', function (event) {
		event.preventDefault();
		if (confirm('Opravdu se chcete odhlásit?')) {
			logout.click();
		}
	});
});");
		return null; // null = pokracuji dalsi pluginy i vychozi head() Admineru
	}

	protected $translations = array(
		'cs' => array('' => 'Odkaz na typ serveru v horní navigaci po potvrzení odhlásí'),
	);
}
