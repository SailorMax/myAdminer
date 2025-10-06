<?php

/** Add current domain to breadcrumb
* @link https://www.adminer.org/plugins/#use
* @author SailorMax, http://www.sailormax.net/
* @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class AdminerDomainInBreadcrumb
{
	function head()
	{
?>
		<script<?=Adminer\nonce()?>>
		document.addEventListener("DOMContentLoaded", function(event)
		{
			var breadcrumb = document.getElementById("breadcrumb");
			if (breadcrumb)
			{
				breadcrumb.insertBefore(document.createTextNode(" » "), breadcrumb.childNodes[0]);

				var link = document.createElement("A");
				link.innerHTML = document.domain;
				link.href = document.location.pathname;
				breadcrumb.insertBefore(link, breadcrumb.childNodes[0]);
			}
		});
		</script>
<?php
	}
}
