<?php

/** <code> text wrap + possibility to show full query + possibility to always show executed query
* @link https://www.adminer.org/plugins/#use
* @author SailorMax, http://www.sailormax.net/
* @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class AdminerExecutedQueryOutputModifier
{
	private $TYPES_LIST = ["text_wrap", "link2show_full", "show_message_queries", "inline_edit_query"];

	function __construct($types_list = [])
	{
		if ($types_list)
		{
			if (!is_array($types_list))
				$types_list = array($types_list);
			$this->TYPES_LIST = $types_list;
		}
	}

	function head()
	{
?>
		<script<?=Adminer\nonce()?>>
		document.addEventListener("DOMContentLoaded", function(event)
		{
<?php
			if (in_array("show_message_queries", $this->TYPES_LIST))
			{
?>
				// show message executed queries
				var childs, j;
				var messages = document.getElementsByClassName("message");
				var i, cnt = messages.length;
				for (i=0; i<cnt; i++)
				{
					childs = messages[i].childNodes;
					for (j=0; j<childs.length; j++)
						if (childs[j].tagName && (childs[j].className.split(/\s+/).indexOf("hidden") != -1))
							childs[j].className = childs[j].className.replace(/\bhidden\b/, "");
				}
<?php
			}

			if (in_array("text_wrap", $this->TYPES_LIST))
			{
?>
				// text wrap in <code> blocks
				var style = document.createElement('style');
				style.type = 'text/css';
				style.innerHTML = 'pre code { white-space: pre-wrap; }';
				document.getElementsByTagName('HEAD')[0].appendChild(style);
<?php
			}

			if (in_array("link2show_full", $this->TYPES_LIST))
			{
?>
				// show full queries link
				var funcShowFullQuery = function(evt)
				{
					var code = evt.srcElement.parentNode;

					// try to get full sql from `export` button
					if (code.parentNode.id)
					{
						var span = document.getElementById(code.parentNode.id.replace("sql-", "export-"));
						if (span)
						{
							var inputs_list = span.getElementsByTagName("INPUT");
							var i, cnt = inputs_list.length;
							for (i=0; i<cnt; i++)
								if (inputs_list[i].name == "query")
								{
									code.innerHTML = inputs_list[i].value;
									return;
								}
						}
					}

					// try to get full sql from `textarea`
					var textareas = document.getElementsByName("query");
					var i, cnt = textareas.length;
					for (i=0; i<cnt; i++)
						if (textareas[i].tagName == "TEXTAREA")	// CHECK: possible in some cases we have few queries per page
						{
							code.innerHTML = textareas[i].textContent;
							return;
						}

					// try to get full sql from `edit` link
					var box_links = code.parentNode.parentNode.getElementsByTagName("A");
					var i, cnt = box_links.length;
					for (i=0; i<cnt; i++)
						if (box_links[i].href.indexOf("&history=") > 0)
						{
							ajax(box_links[i].href, function(request)
							{
								if (request.responseText)
								{
									var textareas_arr = request.responseText.split(/<\/?textarea[^<>]*\>/);
									code.innerHTML = textareas_arr[1];		// content of first textarea
								}
							});
							return;
						}

				};
				var pre_list = document.getElementsByTagName("PRE");
				var i, cnt = pre_list.length;
				for (i=0; i<cnt; i++)
				{
//					<pre> of alter table has no id
//					if (!pre_list[i].id)
//						continue;

					var code_list = pre_list[i].getElementsByTagName("CODE");
					if (!code_list.length)
						continue;

					var italic_list = code_list[0].getElementsByTagName("I");
					if (!italic_list.length)
						continue;

					var link = document.createElement("A");
					link.addEventListener("click", funcShowFullQuery);
					link.style.cursor = "pointer";
					link.innerHTML = italic_list[0].innerHTML;
					code_list[0].insertBefore(link, italic_list[0]);
					code_list[0].removeChild(italic_list[0]);
				}
<?php
			}

			if (in_array("inline_edit_query", $this->TYPES_LIST))
			{
?>
				var code_list = document.getElementsByTagName("CODE");
				if (code_list.length)
				{
					var funcShowInlineEditQuery = function(e)
					{
						var source_button = this;
						ajax(this.href, function(request)
						{
							var source_button_box = source_button.parentNode;
							if (request.responseText)
							{
								var forms_arr = request.responseText.split(/<form[^<>]*\>/);
								if ((forms_arr.length < 2) || (forms_arr[1].indexOf("<textarea") < 0))
									return;

								var form_arr = forms_arr[1].split(/<fieldset[^<>]*\>/);

								var new_form = document.createElement("FORM");
								new_form.innerHTML = form_arr[0];
								new_form.action = source_button.href;
								new_form.method = "post";
								new_form.enctype = "multipart/form-data";

								var new_textarea = new_form.getElementsByTagName("TEXTAREA")[0];
								new_textarea.rows = new_textarea.textContent.split("\n").length + 2;
								new_textarea.style.height = "auto";
								new_textarea.addEventListener("keydown", function(e)
								{
									if (e.keyCode == 27)	// Escape
									{
										source_button_box.style.display = "";
										new_form.parentNode.removeChild(new_form);
									}
								});

								new_form["mySourceCodeBox"] = source_button_box;
								if (source_button_box.style.left != "")
								{
									new_form.style.left = source_button_box.style.left;
									new_form.style.position = source_button_box.style.position;
								}
								source_button_box.parentNode.insertBefore(new_form, source_button_box.nextSibling);
								source_button_box.style.display = "none";
								new_textarea.focus();	// fix dynamic elements, for example with submit_at_right plugin
								if (window.dispatchEvent && Event)
									window.dispatchEvent(new Event('resize'));
							}
						});

						// cancel event
						if (e.stopPropagation) e.stopPropagation();
						if (e.preventDefault) e.preventDefault();
						e.cancelBubble = true;
						e.returnValue = false;
						return false;
					};

					var i, cnt = code_list.length;
					for (i=0; i<cnt; i++)
					{
						if (code_list[i].parentNode.tagName == "PRE")			// user defined query. can be truncated
						{
							// on this page we already has edit window under result
							// nothing to do
						}
						else if (code_list[i].parentNode.tagName == "P")		// auto constructed query (sort, filter,..). always output fully
						{
							var query_element = code_list[i];
							var edit_link = query_element;
							while (edit_link && (edit_link.tagName != "A"))
								edit_link = edit_link.nextSibling;
							if (edit_link && (edit_link.href.indexOf("&sql=") > 0))
								edit_link.addEventListener("click", funcShowInlineEditQuery);
						}
						else
						{
							// other codes, for example in result table
							// nothing to do
						}
					}
				}
<?php
			}
?>
		});
		</script>
<?php
	}
}
