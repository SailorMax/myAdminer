<?php

/** Add [copy] links near current table name and SQL text
* @link https://www.adminer.org/plugins/#use
* @author SailorMax, http://www.sailormax.net/
* @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class AdminerCopyLinks
{
	function head()
	{
?>
		<script<?=Adminer\nonce()?>>
		document.addEventListener("DOMContentLoaded", function(event)
		{
			if ((typeof opera == "object") && opera.version)	// Opera classic did not support manual copy events
				return false;

			var PutTextInCopyBuffer = function(copy_text, sender)
			{
				var success_copy = false;
/*
				// in Firefox first method looks like work, but it didn't
				try
				{
//					var copyEvent = new ClipboardEvent("copy", { dataType: "text/plain", data: copy_text } );
//					document.dispatchEvent(copyEvent);

					var copyEvent = new ClipboardEvent('copy');
					copyEvent.clipboardData.setData('text/plain', copy_text);
					copyEvent.preventDefault();
					copyEvent.returnValue = false;
//					console.log(copyEvent.clipboardData.getData('text/plain'));
					console.log( document.dispatchEvent(copyEvent) );
					console.log(copyEvent);
					success_copy = true;
				}
				catch (err)
*/
				{
					if (document.execCommand)
					{
						var focused_el = document.activeElement;

						var ta = document.createElement("TEXTAREA");
						ta.style.cssText = "position:absolute; left:-1000; top:-1000;";
						ta.textContent = copy_text;
						ta = document.body.appendChild(ta);
						ta.focus();
						ta.select();

						try
						{
							success_copy = document.execCommand('copy');
						}
						catch (err)
						{
						}

						document.body.removeChild(ta);
						if (focused_el)
							focused_el.focus();
					}
				}

				if (!success_copy)
					console.log('Unable to copy');
				else if (sender)
				{
					var GetStyleOfElement = function(el, css_name)
					{
						if (document.defaultView && document.defaultView.getComputedStyle)
							return document.defaultView.getComputedStyle(el, "").getPropertyValue(css_name);
						if (el.currentStyle)
							return el.currentStyle[ css_name.replace(/-(\w)/g, function(){ return arguments[1].toUpperCase(); }) ];
						return "";
					};

					// selection animation
					var bgopacity = 1.0;
					var original_bg_color = GetStyleOfElement(sender, "background-color");
					var bgfade = function()
					{
						bgopacity -= 0.05
						sender.style.backgroundColor = "rgba(255, 255, 0, " + bgopacity + ")";
						if (bgopacity >= 0)
							setTimeout(bgfade, 12);
						else
							sender.style.backgroundColor = original_bg_color;
					}
					bgfade();
				}
			};

			// copy button near table name
			var header_els = document.getElementsByTagName("H2");
			if (header_els.length && (header_els[0].innerHTML.indexOf(":") > 0))
			{
				var copy_link_table = document.createElement("A");
				copy_link_table.style = "font-size: 10px; cursor:pointer;";
				copy_link_table.appendChild( document.createTextNode("[copy]")  );
				copy_link_table.addEventListener("click", function(event)
				{
					var textNode = this.parentNode.childNodes[0];
					var table_name = textNode.textContent;
					if (table_name.indexOf(":") > 0)
					{
						table_name = table_name.split(": ")[1];
						PutTextInCopyBuffer(table_name, this);
					}
				});
				header_els[0].appendChild(copy_link_table);
			}

			// copy button near query test
			var pre_list = document.getElementsByTagName("PRE");
			var i, cnt = pre_list.length;
			if (cnt)
			{
				var copy_link_sql = document.createElement("A");
				copy_link_sql.style = "float:right; margin-top:-1.7em; font-size: 0.8em; cursor:pointer;";
				copy_link_sql.appendChild( document.createTextNode("[copy]")  );

				for (i=0; i<cnt; i++)
				{
					var code_list = pre_list[i].getElementsByTagName("CODE");
					if (code_list.length)
					{
						var copy_link = code_list[0].parentNode.insertBefore(copy_link_sql.cloneNode(true), code_list[0].nextSibling);
						copy_link.addEventListener("click", function(event)
						{
							var codeNodes = this.parentNode.getElementsByTagName("CODE");
							if (codeNodes.length > 0)
							{
								// try to find full uqery
								var span = document.getElementById(codeNodes[0].parentNode.id.replace("sql-", "export-"));
								if (span)
								{
									var inputs_list = span.getElementsByTagName("INPUT");
									var i, cnt = inputs_list.length;
									for (i=0; i<cnt; i++)
										if (inputs_list[i].name == "query")
										{
											PutTextInCopyBuffer(inputs_list[i].value, this);
											return;
										}

								}
								else	// or take as is
									PutTextInCopyBuffer(codeNodes[0].textContent, this);
							}
						});
					}
				}
			}
		});
		</script>
<?php
	}
}
