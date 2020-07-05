$(document).ready(function() {

//dodanie strony
	$(".add_button_subjects").keypress(function (e) {
        if (e.which == 13) {
        e.preventDefault();
        if ($("#subjectsText").val() === '') {
            alert("Puste pole. Wpisz tekst!");
            return false;
        }
        var myData = $("#subjectsText").val();

        jQuery.ajax({
            type: "POST",
            url: "add_subject.php",
            dataType: "text",
            data: {add_subject: myData},
            success: function (response) {
                $("#subjectsText").val('');
                window.location = window.location;
            },
            error: function (xhr, ajaxOptions, thrownError) {

                alert(thrownError);
            }
        });
    }
	});


});