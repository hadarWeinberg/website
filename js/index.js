$(document).ready(function() {
    if (sessionStorage.getItem('user-id')) {
		let message = "שלום " + sessionStorage.getItem("name") + " " + sessionStorage.getItem("last_name") ;
		$('#hello-user').html(message);
        $('#register').hide();
        $('#login').hide();
        $('#logout').show();
    } else {
        $('#register').show();
        $('#login').show();
        $('#logout').hide();
    }
});