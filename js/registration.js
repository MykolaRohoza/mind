function reg (){
    $('input[name="user_name"]').on('keyup',function(){
        validateName($(this));
    });
    
    $('input[name="user_second_name"]').on('keyup',function(){
       validateSecName($(this));
     });
    $('input[name="login"]').on('keyup',function(){
        validateLogin($(this));
    });
    $('input[name="telephone"]').on('keyup',function(){
       validateTelephone($(this));
    });
    $('input[name="password"][required=""], input[name="confirm_password"]').on('keyup',function(){
        validatePassword($('input[name="password"][required=""]'), $('input[name="confirm_password"]'));
    });
    
    $('input[name="regestration"]').on('click', function (){
        registrate();
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

    ;
    var query = validate(true);
    $.ajax({
        type: 'POST',
        url: '/resp/' + query,
        data: query,
        success: function(data){   
            var result = JSON.parse(data);
            if(result) {
                showMessage($('input[name="regestration"]'), result['message']);
            }

        }
    });
}
function validateName(elem){
    var str = elem.val(), message;

    if(/^[a-zA-Zа-яА-Я]{3,20}$/.test(str)){

        message = 1;
    }
    else {
        if(str.length > 20) message = 'Максимальная длина имени 20';
        if(str.length < 3) message = 'Минимальная длина имени 3';
        if(/[^a-zA-Zа-яА-Я]/g.test(str)) message = 'Имя может содержать только буквы';
    }
    showMessage(elem, message);
    return message;
}

function validateSecName(elem){
    var str = elem.val(), message;
    if(/^[a-zA-Zа-яА-Я\-]{3,20}$/.test(str)){
        message = 1;
    }
    else {
        if(str.length > 20) message = 'Максимальная длина фамилии 20';
        if(str.length < 3) message = 'Минимальная длина фамилии 3';
        if(/[^a-zA-Zа-яА-Я]/g.test(str)) message = 'Фамилия может содержать только буквы';
    }
        showMessage(elem, message);
}
function validateLogin(elem){
    var str = elem.val(), message;
    if(/^[\d\w]{3,15}@[\d\w]{3,10}\.[\d\w]{2,10}(\.[\d\w]{2,10})?$/.test(str)){
        message =  1;
    }
    else {
        if(str.length > 20) message = 'Максимальная длина логина 20';
        if(str.length < 5) message = 'Минимальная длина логина 5';
        if(!message) message = 'проверьте правильность введения почты';
        
    }
    showMessage(elem, message);
}


function validateTelephone(elem){
    var str = elem.val(), message;
    str = str.replace(/\+|\-|\(|\)|\s/g, '');
    str = str.replace(/^(38)/, '');
    if(/^[\d]{10,15}$/.test(str)){
   
        message = 1;
    }
    else {
        if(/^[^\d]$/.test(str)) message = 'Телефон может содержать только цифры пробелы и () -+';
        if(str.length < 10) message = 'Минимальная длина телефона 10';
        if(str.length > 15) message = 'Максимальная длина телефона 15';


    }
    showMessage(elem, message);
}
function validatePassword(elem1, elem2){
    var pass = elem1.val(),
        dbl_pass = elem2.val(),
        message;

    if(/^[\d\w]{5,20}$/.test(pass)){
        if(pass !== dbl_pass){
            message = 'пароли не совпадают';
        }
         else  message = 1;
    }
    else {
        if(pass.length > 20) message = 'Максимальная длина пароля 20';
        if(pass.length < 5) message = 'Минимальная длина пароля 5';
        if(!message) message ='Пароль может содержать только латинские буквы и цифры';
    }
    showMessage(elem1, message);
}
function validate(){
    validateName( $('input[name="user_name"]'));
    validateSecName($('input[name="user_second_name"]'));
    validateLogin($('input[name="login"]'));
    validateTelephone($('input[name="telephone"]'));
    validatePassword($('input[name="password"][required=""]'), $('input[name="confirm_password"]'));
  
}
function getQuery(){

    var query = 'registration=&message=hi';
    return query;
}

function showMessage(elem, message){

    var parent = elem.parent();
    parent.children('span[class="message"]').remove();
    parent.children('br:first').remove();
    if(message !==1) {
        parent.prepend('<span class="message" style="color:red">' + message + '</span> <br>');
    }

}


