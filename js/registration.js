function reg (){
    
//    $('input[name="login"]').on('keyup',function(){
//        var message = validateLogin($(this).val());
//
//            showMessage($(this), message);
//
//    });
//    $('input[name="tel"]').on('keyup',function(){
//        var message = validateTelephone($(this).val());
//
//            showMessage($(this), message);
//
//    });
//    $('input[name="pass"], input[name="dbl_pass"]').on('keyup',function(){
//        var message = validatePassword($('input[name="pass"]').val(), $('input[name="dbl_pass"]').val());
//
//            showMessage($('input[name="pass"]'), message);
//
//    });
    
    $('input[name="regestration"]').on('click', function (){
        registrate();
    });

    $('input[name="clean"]').on('click', function (){
        $('input[name="login"]').val('');
        $('select[name="sities"] option[value!="0"]').remove();
        $('select[name="countries"]').val(0);
        $('input[name="tel"]').val('');
        $('input[name="pass"]').val('');
        $('input[name="dbl_pass"]').val('');
        //clear masseges
        showMessage($('input[name="login"], input[name="pass"], input[name="tel"]'), 1);
        //reload invate
        getInvite();
    });
    

}

function registrate(){
//    var login =  $('input[name="login"]').val(),
//        city = $('select[name="sities"]').val(),
//        country = $('select[name="countries"]').val(),
//        tel = $('input[name="tel"]').val(),
//        pass = $('input[name="pass"]').val(),
//        invite = $('input[name="invite"]').val();  
//    var query = 'reg=&login=' + login + '&country=' + country + '&city=' + city + 
//            '&tel=' + tel + '&pass=' + pass + '&invite=' + invite;
var query = 'registration=&message=hi';
    $.ajax({
        type: 'POST',
        url: '/resp/' + query,
        data: query,
        success: function(data){   
        console.log(data);
            var result = JSON.parse(data);
            if(result) {
                showMessage($('input[name="regestration"]'), result);
            }

        }
    });
}




function showMessage(elem, message){
    //color = (color !== undefind)?color:color='red';
    var parent = elem.parent();
    parent.children('span[class="message"]').remove();
    parent.children('br:first').remove();
    if(message !==1) {
        parent.prepend('<span class="message" style="color:red">' + message + '</span> <br>');
    }

}


