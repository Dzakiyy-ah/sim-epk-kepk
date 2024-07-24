function show_success(ttl, msg)
{
	$.gritter.add({
		// (string | mandatory) the heading of the notification
		title: "Sukses!",
		// (string | mandatory) the text inside the notification
		text: msg,
		class_name: 'gritter-success gritter-center'
	});

	return false;
}

function show_error(ttl, msg)
{
	$.gritter.add({
		// (string | mandatory) the heading of the notification
		title: "Gagal!",
		// (string | mandatory) the text inside the notification
		text: msg,
		class_name: 'gritter-error gritter-center'
	});

	return false;
}