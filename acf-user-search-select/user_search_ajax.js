(function($) {

   /* resultField.html("<a href='" + $siteurl + "/wp-admin/user-edit.php?user_id=" + uid + "' target='_blank'>" + responseText + "</a>"); */

    /* on load wrap custom field with our elements */
    $('.user_search').each(function(index){
        //this should be each custom user_search field containing the userid
        $index=index;
        $(this).wrap('<div class="searchDiv" />');
        $(this).after('<div class="searchResult"></div>');
        $(this).after('<input type="text" name="searchUsersName" class="searchUsersName" value="" autocomplete="off">');
        $(this).hide();

     });

    /* run after the page has loaded */
    $(function() {        
        $('.searchDiv').each(function(index){
             var acfField=$(this).find('.user_search'); //id field
             var userNameField=$(this).find('.searchUsersName');//user name-type to search
             var resultField=acfField.siblings().eq(1);//show search results
             var uid=acfField.val();//get id
             var uname=userNameField.val();//get user name
			 
             

            if ((!uid == '') && (uname == '')){
               $.ajax({
               type: 'GET',
               url: "/wp-content/plugins/acf-user-search-select/UserSearch.php",
               data: 'uid=' + uid + '&mode=getuser',
                async: false,
               success: function(responseText){
                   userNameField.val(responseText);
                    var siteurl = window.location.hostname;
                    resultField.html("<a href='/wp-admin/user-edit.php?user_id=" + uid + "' target='_blank'>" + responseText + "</a>");
               } 
             }); 
            }
         });
    });

    /* onKeyup fire ajax */
    $('.searchUsersName').live('keyup',function(){
         var contdiv=$(this).closest('div');
         var acfField=contdiv.find('.user_search');
         var acfFieldId=acfField.attr('id');
         var userNameField=acfField.next('input').attr('class');
         var resultField=acfField.siblings().eq(1).attr('class');
         var id=acfField.val();
         var inputText=acfField.next('input').val();
		 
        
        if(inputText.length>=3){
            $.ajax({
                type: 'GET',
                url: "/wp-content/plugins/acf-user-search-select/UserSearch.php",
                
				data: 'inputText=' + encodeURIComponent(inputText) + '&mode=getmatches&acf=' + acfFieldId + '&name=' + userNameField + '&result=' + resultField,
                success: function(responseText){
                    acfField.siblings().eq(1).html(responseText);
                }
            });  
        }else{
            acfField.siblings().eq(1).html('');
        }   
    });//end key up function
     
 })(jQuery);
