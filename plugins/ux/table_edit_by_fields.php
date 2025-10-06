<?php

/** Table editor reduce submitted fields
* @link https://www.adminer.org/plugins/#use
* @author SailorMax, http://www.sailormax.net/
* @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class AdminerTableEditByFields
{
	function head()
	{
		if (Adminer\adminer()->database() === null)
			return;

		if (!function_exists("get_page_table"))		// not modified adminer sources does not support this plugin
			return;
?>
		<script<?=Adminer\nonce()?>>
		document.addEventListener("DOMContentLoaded", function(event)
		{
			var fieldsTable = document.getElementById("edit-fields");
			if (!fieldsTable)
				return false;

			// get text words (edit / modify)
			// TODO: use JS side dictionary, when it will be ready
			var current_location = document.location.href;
			if (!window.myAjax)
			{
				var myAjaxScript = document.createElement("SCRIPT");
				myAjaxScript.innerHTML = ("var myAjax = "+ajax).replace("function ajax(", "function(").replace(/([\'\"]X-Requested-With[\'\"]\s*,\s*[\'\"])XMLHttpRequest([\'\"])/, "$1$2");
				myAjaxScript.nonce = '<?=Adminer\nonce()?>'.replace(/^[^"]+"/, "").replace(/"$/, "");
				document.getElementsByTagName("BODY")[0].appendChild(myAjaxScript);
			}

			if (!window.myEditingCommentsClick)
			{
				var myCommentClickScript = document.createElement("SCRIPT");
				myCommentClickScript.innerHTML = ("var myEditingCommentsClick = "+editingCommentsClick).replace("function editingCommentsClick(", "function(").replace(", 6)", ", 7)");
				myCommentClickScript.nonce = '<?=Adminer\nonce()?>'.replace(/^[^"]+"/, "").replace(/"$/, "");
				document.getElementsByTagName("BODY")[0].appendChild(myCommentClickScript);
			}

			// via modified function, because we need full page, not only result table
			myAjax(current_location.replace(/&create=([^&]*)/, "&select=$1")+"&limit=1", function(request)
			{
				var edit_link;
				var edit_word, code_re = new RegExp("<code[^>]*>[^<]+</code>\\s*<span[^>]*>[^<]+</span>\\s*<a[^>]*>([^<]+)</a>");
				if (request.responseText && (request.responseText.indexOf("<"+"code") > 0) && (edit_word = request.responseText.match(code_re)))
				{
					// take "edit" word from <code> post link
					edit_word = edit_word[1].toLowerCase();

					// add new column with "edit" link
					edit_link = document.createElement("A");
					edit_link.href = "javascript:;";
					edit_link.innerText = edit_word;
				}
				// else no $edit_link => this is create table form


				var funcEditTableField = function(evt)
				{
					if (evt.target && evt.target.type && (evt.target.type == "image") && (evt.target.name.indexOf("up[") !== 0) && (evt.target.name.indexOf("down[") !== 0))
						return false;
					if (evt.keyCode && (evt.keyCode == 9))
						return false;

					var row = evt;
					if (evt.target)
						row = this;

					while (row.tagName != "TR")
						row = row.parentNode;

					var inputs, j, inputs_cnt;
					inputs = row.getElementsByTagName("INPUT");
					inputs_cnt = inputs.length;
					for (j=0; j<inputs_cnt; j++)
						if ((inputs[j].type != "image") && (inputs[j].type != "hidden"))
							inputs[j].disabled = false;

					inputs = row.getElementsByTagName("SELECT");
					inputs_cnt = inputs.length;
					for (j=0; j<inputs_cnt; j++)
						inputs[j].disabled = false;

					row.cells[0].getElementsByTagName("A")[0].style.visibility = "hidden";

					if (evt.target)
						evt.target.focus();
				}

				var auto_increment_selected = null;
				uxEditableFieldBeforeAction = function(sender)
				{
					if (sender.type == "change")	// check on event
					{
						sender = this;
						if (sender.name == "auto_increment_col")
						{
							uxEditableFieldBeforeAction(auto_increment_selected);
							auto_increment_selected = sender;
						}
					}
					funcEditTableField(sender);
					return true;
				}

				var i, headers = [];
				if (edit_link)
					headers.push("");			// first column - "edit"
				if (fieldsTable.rows.length)
				{
					var cells_cnt = fieldsTable.rows[0].cells.length;
					for (i=0; i<cells_cnt; i++)
						headers.push( fieldsTable.rows[0].cells[i].innerText.replace(/(^\s+|\s+$)/g, "") );
				}

				var new_cell, curr_row, inputs, j, inputs_cnt, cell;
				var rows_cnt = fieldsTable.rows.length;
				for (i=0; i<rows_cnt; i++)
				{
					var curr_row = fieldsTable.rows[i];
					if (edit_link)
						new_cell = curr_row.insertCell(0);

					if (curr_row.parentNode.tagName == "TBODY")
					{
						if (edit_link)
							new_cell.appendChild( edit_link.cloneNode(true) );//.addEventListener("click", funcEditTableField);
						inputs = curr_row.getElementsByTagName("INPUT");
						inputs_cnt = inputs.length;
						for (j=0; j<inputs_cnt; j++)
							if (inputs[j].type == "image")
							{
								if (edit_link && inputs[j].name.indexOf("add[") === 0)
								{
									var originalOnClick = inputs[j].onclick;
									inputs[j].onclick = function(event){
										uxEditableFieldBeforeAction(this);
										originalOnClick.apply(this);
										return false;
									};
								}
							}
							else if (inputs[j].type != "hidden")
							{
								if (edit_link)
								{
									if (inputs[j].name.indexOf("][field]") < 0)
										inputs[j].disabled = true;
									else if (inputs[j].value == "")
										inputs[j].focus();

									if (inputs[j].name == "auto_increment_col")
									{
										inputs[j].addEventListener("change", uxEditableFieldBeforeAction);
										if (inputs[j].checked)
											auto_increment_selected = inputs[j];
									}
								}

								if (inputs[j].title === "")
								{
									cell = inputs[j];
									while (cell && !cell.cellIndex)
										cell = cell.parentNode;
									if (cell)
										inputs[j].title = headers[ cell.cellIndex ];
								}
							}

						if (edit_link)
						{
							inputs = curr_row.getElementsByTagName("SELECT");
							inputs_cnt = inputs.length;
							for (j=0; j<inputs_cnt; j++)
								inputs[j].disabled = true;
						}
					}
					else if (curr_row.parentNode.tagName == "THEAD")
					{
						inputs = curr_row.getElementsByTagName("INPUT");
						if (inputs.length && (inputs[0].name == "auto_increment_col"))
						{
							inputs[0].addEventListener("change", uxEditableFieldBeforeAction);
							if (inputs[0].checked)
								auto_increment_selected = inputs[0];
						}
					}

					if (edit_link)
					{
						fieldsTable.rows[i].addEventListener("keyup", funcEditTableField);
						fieldsTable.rows[i].addEventListener("mouseup", funcEditTableField);
					}
				}

				if (edit_link)
				{
					// fix "Default" and "Comment" checkbox handlers. We have +1 column => shift previous indexes
					var inp_defaults = document.getElementsByName("defaults");
					for (i=0; i<inp_defaults.length; i++)
						if (inp_defaults[i].form === fieldsTable.parentNode.parentNode)
						{
							inp_defaults[i].onclick = function(){
								columnShow(this.checked, 6);
							};
							break;
						}
					var inp_comments = document.getElementsByName("comments");
					for (i=0; i<inp_comments.length; i++)
						if (inp_comments[i].form === fieldsTable.parentNode.parentNode)
						{
							inp_comments[i].onclick = function () { myEditingCommentsClick(this, true); };		// column 7
							break;
						}
				}
			});
		});
		</script>
<?php
	}
}
