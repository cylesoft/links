window.onload = init_links;

function init_links() {	
	if (document.getElementById('options') != undefined) {
		// listen for option button presses
		document.getElementById('option_ts').addEventListener('click', option_ts_action);
		document.getElementById('option_ut').addEventListener('click', option_ut_action);
		document.getElementById('option_priv').addEventListener('click', option_priv_action);
	}
	if (document.getElementById('list') != undefined) {
		// listen for edit button presses
		var edit_buttons = document.getElementsByClassName('editlink');
		for (var i = 0; i < edit_buttons.length; i++) {
			edit_buttons[i].addEventListener('click', edit_action);
		}
		
		// listen for delete button presses
		var delete_buttons = document.getElementsByClassName('deletelink');
		for (var i = 0; i < delete_buttons.length; i++) {
			delete_buttons[i].addEventListener('click', delete_action);
		}
	}
}

function option_ts_action(e) {
	// is it hide or show?
	var show = e.target.checked;
	// show or hide
	var spans = document.getElementsByClassName('when');
	for (var i = 0; i < spans.length; i++) {
		if (show) {
			spans[i].style.display = 'inline';
		} else {
			spans[i].style.display = 'none';
		}
	}
	// send request to set this as default
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4) {
			if (xmlhttp.status == 200) {
				// saved!
				console.log('saved timestamp option setting');
			} else if (xmlhttp.status == 400) {
				console.error('There was an error 400 when trying to save the timestamp option: ' + xmlhttp.responseText);
			} else if (xmlhttp.status == 500) {
				console.error('There was an error 500 when trying to save the timestamp option: ' + xmlhttp.responseText);
			} else {
				console.error('Something else other than 200 was returned when saving the timestamp option: ' + xmlhttp.responseText);
			}
		}
	}
	xmlhttp.open("POST", "/of/links/process_users.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("a=o&option=ts&value=" + (show ? 1 : 0));
}

function option_ut_action(e) {
	// is it hide or show?
	var show = e.target.checked;
	// show or hide
	var spans = document.getElementsByClassName('utils');
	for (var i = 0; i < spans.length; i++) {
		if (show) {
			spans[i].style.display = 'inline';
		} else {
			spans[i].style.display = 'none';
		}
	}
	// send request to set this as default
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4) {
			if (xmlhttp.status == 200) {
				// saved!
				console.log('saved utilities option setting');
			} else if (xmlhttp.status == 400) {
				console.error('There was an error 400 when trying to save the utilities option: ' + xmlhttp.responseText);
			} else if (xmlhttp.status == 500) {
				console.error('There was an error 500 when trying to save the utilities option: ' + xmlhttp.responseText);
			} else {
				console.error('Something else other than 200 was returned when saving the utilities option: ' + xmlhttp.responseText);
			}
		}
	}
	xmlhttp.open("POST", "/of/links/process_users.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("a=o&option=ut&value=" + (show ? 1 : 0));
}

function option_priv_action(e) {
	// is it private by default?
	var default_private = e.target.checked;
	// check off the form's privacy control
	document.getElementById('privpost').checked = default_private;
	// send request to set this as default
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4) {
			if (xmlhttp.status == 200) {
				// saved!
				console.log('saved default private option setting');
			} else if (xmlhttp.status == 400) {
				console.error('There was an error 400 when trying to save the default private option: ' + xmlhttp.responseText);
			} else if (xmlhttp.status == 500) {
				console.error('There was an error 500 when trying to save the default private option: ' + xmlhttp.responseText);
			} else {
				console.error('Something else other than 200 was returned when saving the default private option: ' + xmlhttp.responseText);
			}
		}
	}
	xmlhttp.open("POST", "/of/links/process_users.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("a=o&option=priv&value=" + (default_private ? 1 : 0));
}

function edit_action(e) {
	var link_id = e.target.getAttribute('data-id') * 1;
	if (link_id == undefined || link_id == 0) {
		return;
	}
	console.log('editing link ID ' + link_id);
	//console.log(e);
	var target_content = e.target.parentNode.parentNode.getElementsByClassName('content')[0];
	var privacy_setting = target_content.children[0].value * 1;
	target_content.removeChild(target_content.children[0]);
	var target_html = target_content.innerHTML;
	// replace all links with just the link URLs
	var link_regex = /<a[^href]*href="([^"]+)"[^>]*>[^<]+<\/a>/ig;
	var reverted_content = target_html.replace(link_regex, '$1');
	var edit_content_form = '';
	edit_content_form += '<input id="content-'+link_id+'" class="content_input" type="text" value="'+reverted_content+'" /> ';
	edit_content_form += '<input id="privacy-'+link_id+'" type="checkbox" title="your eyes only?" name="p" value="1" '+(privacy_setting == 1 ? 'checked="checked"' : '')+' /> ';
	edit_content_form += '<input id="save-'+link_id+'" data-id="'+link_id+'" type="button" class="submitbtn" value="save" />';
	target_content.innerHTML = edit_content_form;
	//console.log(target_content);
	document.getElementById('save-'+link_id).addEventListener('click', save_edit_action);
}

function save_edit_action(e) {
	// save the current link edit
	var link_id = e.target.getAttribute('data-id') * 1;
	if (link_id == undefined || link_id == 0) {
		return;
	}
	console.log('saving edited link ID ' + link_id);
	//console.log(e);
	var new_content = document.getElementById('content-'+link_id).value;
	var privacy_setting = document.getElementById('privacy-'+link_id).checked;
	//console.log('new content: ' + new_content);
	//console.log('privacy: ' + privacy_setting);
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4) {
			if (xmlhttp.status == 200) {
				document.getElementById('link-'+link_id).getElementsByClassName('content')[0].innerHTML = xmlhttp.responseText;
			} else if (xmlhttp.status == 400) {
				console.error('There was an error 400 when trying to delete the link: ' + xmlhttp.responseText);
			} else if (xmlhttp.status == 500) {
				console.error('There was an error 500 when trying to delete the link: ' + xmlhttp.responseText);
			} else {
				console.error('Something else other than 200 was returned when trying to delete the link: ' + xmlhttp.responseText);
			}
		}
	}
	xmlhttp.open("POST", "/of/links/process_links.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("a=e&id="+link_id+"&p="+(privacy_setting ? '1' : '0')+"&t="+encodeURIComponent(new_content));
	
}

function delete_action(e) {
	if (confirm('Are you sure you want to delete that link?') == false) {
		return;
	}
	var link_id = e.target.getAttribute('data-id') * 1;
	if (link_id == undefined || link_id == 0) {
		return;
	}
	console.log('deleting link ID ' + link_id);
	//console.log(e);
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4) {
			if (xmlhttp.status == 200) {
				// deleted! remove from view
				var to_delete = document.getElementById('link-'+link_id);
				to_delete.parentNode.removeChild(to_delete);
			} else if (xmlhttp.status == 400) {
				console.error('There was an error 400 when trying to delete the link: ' + xmlhttp.responseText);
			} else if (xmlhttp.status == 500) {
				console.error('There was an error 500 when trying to delete the link: ' + xmlhttp.responseText);
			} else {
				console.error('Something else other than 200 was returned when trying to delete the link: ' + xmlhttp.responseText);
			}
		}
	}
	xmlhttp.open("POST", "/of/links/process_links.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("a=d&id="+link_id);
}