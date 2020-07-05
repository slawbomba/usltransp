$(document).ready(function() {

//##### dodanie page #########
	$(".add_button_page").keypress(function (e) {
if(e.which==13) {
    e.returnValue = false;
    e.preventDefault();
    var clickedID = this.id.split('-');
    var DbNumberID = clickedID[1];

    if ($(".contentText" + DbNumberID).val() === '') {
        alert("Please enter some text!");
        return false;
    }

    var tresc = $(".contentText" + DbNumberID).val();
    var numer = DbNumberID;

    jQuery.ajax({
        type: "POST",
        url: "add_pages.php",
        dataType: "text",
        data: {q1: tresc, q2: numer},
        success: function (response) {
            $("#navigation").append(response);
            $(".contentText" + DbNumberID).val('');
            window.location = window.location;
        },
        error: function (xhr, ajaxOptions, thrownError) {

            alert(thrownError);
        }
    });
}
	});
//##### dodanie subject #########
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


	//dodanie artykulu na subj
	$(".add_button_article_subj").click(function (e){
        e.returnValue = false;
        e.preventDefault();
        var clickedID = this.id.split('-');
        var DbNumberID = clickedID[1];

        if($(".contenttytul").val()==='')
        {
            alert("wpisz tytul");
            return false;
        }
        else if($(".contenttext").val()==='')
        {
            alert("wpisz artykul");
            return false;
        }

        var tytul = $(".contenttytul").val();
        var tresc = $(".contenttext").val();
        var numer = DbNumberID;

        jQuery.ajax({
            type: "POST",
            url: "add_article_subj.php",
            dataType:"text",

            data:{q1:tytul,q2:tresc,q3:numer},
            success:function(response){
                $(".contenttytul").val('');
                $(".contenttext").val('');
                window.location = window.location;
            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError);
            }
        });

    });


    $(".add_user").click(function (e){

        var clickedID = this.id.split('-');
        var DbNumberID = clickedID[1];

        var numer = DbNumberID;

        jQuery.ajax({
            type: "POST",
            url: "add_user.php",
            dataType:"text",
            data:{q1:numer},
            success:function(response){
                $('#item_' + DbNumberID).fadeOut("slow");

            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError);
            }
        });

    });


    $(".del_button").click(function (e)         {

        var clickedID = this.id.split('-');
        var DbNumberID = clickedID[1];
        var myData = 'recordToDelete='+ DbNumberID;
            jQuery.ajax({

                type: "POST",
                url: "del_page.php",
                dataType: "text",
                data: myData,
                success: function (response) {
                    
                    $('.menu_dropdown' + DbNumberID).fadeOut("slow");
                    window.location="index.php";
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        
    });
    $(".del_button_subject").click(function (e)         {

        var clickedID = this.id.split('-');
        var DbNumberID = clickedID[1];
        var myData = 'recordToDelete='+ DbNumberID;
            jQuery.ajax({

                type: "POST",
                url: "del_subj.php",
                dataType: "text",
                data: myData,
                success: function (response) {
                    window.location.href = "index.php";
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });

    });

    $(".del_button_article").click(function (e) {
        e.returnValue = false;
        var clickedID = this.id.split('-');
        var DbNumberID = clickedID[1];
        var myData = 'recordToDelete='+ DbNumberID;

        jQuery.ajax({
            type: "POST",
            url: "del_article.php",
            dataType:"text",
            data:myData,

        success:function(response){
                za
                $("#article_"+DbNumberID).fadeOut("fast");
          
            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError);
            }
        });

    });


	   // funkcja wywoływana w momencie zaznaczenia elementu o id=signup, w tym przypadku inputa typu radio
   $('#signup').click(function(){
	   $('#username').val('');
      $('#hashed_password').val(''); // czyścimy zawartosć inputa o id=password
      $('#login_block').hide(); // chowamy diva z logowaniem
      $('#signup_block').show(); // pokazujemy diva z rejestracją
   });
   // funkcja wywoływana w momencie zaznaczenia elementu o id=login, w tym przypadku inputa typu radio
   $('#login').click(function(){
	   $('#username_check').val('');
	   $('#email').val('');
      $('#hashed_password').val(''); // czyścimy zwartośc inputa o id=newpassword
      $('#signup_block').hide(); // chowamy diva z rejestracją
      $('#login_block').show(); // pokazujemy diva z logowaniem
   });



	$('#username_check').keyup(username_check);


function username_check(){
var username = $('#username_check').val();

if(username == "" || username.length < 4){
$('#username_check').css('border', '3px #CCC solid');

}else{

jQuery.ajax({
   type: "POST",
   url: "check.php",
   data: 'username_check='+ username,
   cache: false,
   success: function(response){
if(response == 1){
	$('#username_check').css('border', '3px #C33 solid');

	}else{
	$('#username_check').css('border', '3px #090 solid');

	     }
}
});
}
}

});