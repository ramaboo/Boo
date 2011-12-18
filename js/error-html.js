/**
 * This file is used by Boo_Error::htmlError() for show/hide functionality.
 * This is a system file used only by the error handler you should not need to change it.
 * Edit at your own risk. Do not using jQuery in this file.
 */
function booToggleCodeVisibility() {
	var el = document.getElementById(this.id + '-code');
	
	if (el.style.display != 'none') {
		el.style.display = 'none';
		this.innerHTML = 'show';
	} else {
		el.style.display = '';
		this.innerHTML = 'hide';
	}
	
	return false;
}
document.getElementById('boo-error-symbols').onclick = booToggleCodeVisibility;
document.getElementById('boo-error-globals').onclick = booToggleCodeVisibility;
document.getElementById('boo-error-server').onclick = booToggleCodeVisibility;
document.getElementById('boo-error-get').onclick = booToggleCodeVisibility;
document.getElementById('boo-error-post').onclick = booToggleCodeVisibility;
document.getElementById('boo-error-files').onclick = booToggleCodeVisibility;
document.getElementById('boo-error-cookie').onclick = booToggleCodeVisibility;
document.getElementById('boo-error-session').onclick = booToggleCodeVisibility;
document.getElementById('boo-error-request').onclick = booToggleCodeVisibility;
document.getElementById('boo-error-env').onclick = booToggleCodeVisibility;