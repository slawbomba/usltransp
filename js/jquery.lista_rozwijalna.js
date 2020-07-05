
(

function($)

{
    $.fn.sugestie = function(config) {

        var defaults = {
    
          };
    
        var config = $.extend(defaults, config);

        config.addParams = (config.addParams != '') ? '&' + config.addParams : '';

        $('<div class="listaBox"><img src="images/arrow.png" /><ul></ul></div>').appendTo('.' + config.className);
        $(".listaBox > ul li").live('mouseover', function()
        {	
			var sel = $(this).parent().find("li[class='wybor']").removeClass('wybor');
			$(this).addClass('wybor');
		});
		
		$("." + config.className + " > input").keyup(function(event)
        {

       var fieldParent = $(this).parents('div.' + config.className);

           if (event.which != 39 && event.which != 37 
           && event.which != 38 && event.which != 40 
           && event.which != 13 && event.which != 9 ) {
                
                fieldVal = fieldParent.find('input:eq(0)').val();
                suggest(fieldVal,this.id);
           } else {
             
             var fieldChild  = fieldParent.find('.listaBox > ul');
             switch (event.which)
                {
                 case 40: { keyEvent(fieldChild,'next');break; }case 38: { keyEvent(fieldChild,'prev');break; }
                 case 13:
                 {
                        fieldParent.children('input:eq(0)').val($("li[class='wybor'] a").text());
						
						
                        if (config.rtnIDs==true) fieldParent.children('input:eq(1)').val($("li[class='wybor']").attr("id"));
                        fieldParent.children('div.listaBox').hide();
                        return false;
                        break;
                 }
                 case 9:
                 {
                        offFocus(this); $("li").removeClass("wybor");
                        break;
                 }
             }
         }
        });

		$("." + config.className).bind("keypress", function(event) {
		  if (event.keyCode == 13) return false;
		});

        $("." + config.className + " > input").live("blur", function(){ offFocus(this); $("li").removeClass("wybor"); });
    
        function suggest(dataInput, id)
        {
            if(dataInput.length < config.minChars) {
                    $('#'+id).parent('.' + config.className).children('div.listaBox').fadeOut();
            } else {
            $('#' + id + ":eq(0)").addClass('lista-load');
                $.ajax({
                   type: config.methodType,
                    url: config.dataFile,
               dataType: "html",
                   data: "data=" + dataInput + "&id=" + id + config.addParams,
                success: function(data){
                    if(data.length >0)
                    {
                        $('#'+id).parent('div.' + config.className).children('div.listaBox').fadeIn();
                        $('#'+id).parent('div.' + config.className).find('.listaBox > ul').html(data);
                        $('#'+ id + ":eq(0)").removeClass('lista-load');
                    }
                    else
                    {
                        $('#' + id + ":eq(0)").removeClass('lista-load');
                    }
                }
              });
            }
        }

		function keyEvent (fieldChild,action)
		{
			yx = 0;
			fieldChild.find("li").each(function(){
				if($(this).attr("class") == "wybor")
                yx = 1;
            });
            
			if(yx == 1)
            {
				var sel = fieldChild.find("li[class='wybor']");
				(action=='next') ? sel.next().addClass("wybor") : sel.prev().addClass("wybor");
				sel.removeClass("wybor");
            }
            else
			{
				(action=='next') ? fieldChild.find("li:first").addClass("wybor") : fieldChild.find("li:last").addClass("wybor");
			}
        }

      function offFocus(fieldChild)
       {
            var fieldParent =  $(fieldChild).parents('div.' + config.className);
            fieldParent.children('div.listaBox').delay(config.fadeTime).fadeOut();
        }

        $(".listaBox > ul li").live("click", function()
        {
           var fieldParent = $(this).parents('div.' + config.className);
         fieldParent.children('input:eq(0)').val($(this).text());
            if (config.rtnIDs==true) fieldParent.children('input:eq(1)').val($(this).attr("id"));
            fieldParent.children('div.listaBox').hide();
        });

    };
})(jQuery);