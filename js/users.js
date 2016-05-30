$(function() {
    $('.full_container').hide();
    $('.exercises_container').sortable({
        delay: 250,
        start: function() {
        },
        stop: function() {
            
        }
        
    });  
    
    setDraggable(); 
    $('input[name="add_ex"]').on('click', function (){
        var ex_name = $('input[name="new_ex"]').val().trim();
        addNewEx(ex_name);
        addNewExGetAll(ex_name);
    });
    $('input[name="exercise"]').on('click', function (){
        
        save_exercises($(this));
    });
    
    $('div.more').on('click', function (){
        show_users_info($(this));
    });

});
function  show_users_info(elem){
    var cont = elem.siblings('.full_container');
        if(cont.is(':hidden')){
            cont.slideDown("slow");
            elem.children('span').removeClass();
            elem.children('span').addClass('glyphicon glyphicon-arrow-up');
        }
        else{
            cont.slideUp("slow");
            elem.children('span').removeClass();
            elem.children('span').addClass('glyphicon glyphicon-arrow-down');
        }

}

function  save_exercises(elem){
    var id_user =  elem.siblings('input[name="id_user"]').val();
    var cont = elem.parent('form').siblings('.exercises_container'); 

    var exercises = cont.children('.exercise'), glue = '==||##', user_ex = glue;
    for (var i = 0; i < exercises.length; i++){
        var exercise = $(exercises[i]);
        user_ex += glue + exercise.children('input[name="id_exercise"]').val()  
                + glue + exercise.children('span.ex').html()  
                + glue + exercise.children('span.counts').html()
                + glue + exercise.children('span.repeat').html();
    }
    var query = 'id_user=' + id_user + '&add_user_ex=' +  user_ex;

    $.ajax({
        type: 'POST',
        url: '/resp/' + query,
        data: query,
        start: function (){
            
        },
        success: function(data){
            var result = JSON.parse(data);
            if(result) {
                cont.empty();
                for (var i = 0; i < result.length; i++){    
                    createExercise(cont, result[i]['id'], result[i]['ex'], result[i]['count'], result[i]['repeat']);
                }
            }
            else{

            }
        }
    });
    
}

function onStopDrag(){

    $('.exercises_container div.ui-draggable div').remove();
    var cont = $('.exercises_container div.ui-draggable').removeAttr('class');
    cont.addClass('exercise').append(
                            '<span class="counts">30</span>'
                            + '<div class="pd_btn plus" onclick="plus_counts(this)"></div>'
                            + '<div class="pd_btn deg" onclick="deg_counts(this)"></div>'
                            + '<span> X </span>'
                            + '<span class="repeat">2</span>'
                            + '<div class="pd_btn plus" onclick="plus_rep(this)"></div>'
                            + '<div class="pd_btn deg" onclick="deg_rep(this)"></div>'
                        );

}
function onStartDrag(){
    //alert('start');
}
function onStopSort(){
    alert('stop');
}
function onStopSort(){
    alert('stop');
}

function addNewEx(str, id_exercise){
    if(str !== undefined && str.trim().length > 0 ){
        // Добавить проверку на номер
        id_exercise = (id_exercise === undefined)?0:id_exercise;
        $('div.container_add_ex').append(
                '<div class="exercise ui-draggable">'
                + '<input type="hidden" name="id_exercise"  value="' + id_exercise + '">'
                + '<span class="ex">' + str + '</span>'
                + '<div class="pd_btn deg" onclick="deg_ex(this)"></div>'
                + '</div>'
        );
        
    }
}
function addNewExGetAll(str, id_exercise){
    if(str !== undefined && str.trim().length > 0){
    id_exercise = (id_exercise === undefined)?0:id_exercise;
    var query = 'add_new_ex=' + str;
    $.ajax({
        type: 'POST',
        url: '/resp/' + query,
        data: query,
        success: function(data){
            var result = JSON.parse(data);
            if(result) {
                $('div.container_add_ex').remove();
                $('#exercise_bank').append('<div class="container_add_ex">');
                $.each(result, function(id_exercise, str) {
                    addNewEx(str, id_exercise);
                });
                setDraggable();
            }
            else{

            }


        }
    });
    }
}
function plus_counts(elem){
    var span = $(elem).siblings('span.counts');
    var val = parseInt(span.html());
    val++;
    span.html(val);
}
function deg_counts(elem){
    var span = $(elem).siblings('span.counts');
    var val = parseInt(span.html());
    val--;
    if(val >= 0){
        span.html(val);
    }
    else{
        span.html(0);
    }
}
function plus_rep(elem){
    elem = $(elem);
    var span = elem.siblings('span.repeat');
    var val = parseInt(span.html());
    val++;
    span.html(val);
}
function deg_rep(elem){
    elem = $(elem);
    var span = elem.siblings('span.repeat');
    var val = parseInt(span.html());
    val--;
    if(val >= 0){
        span.html(val);
    }
    else{
        elem.parent().remove();
    }
}

function deg_ex(elem){
    var jElem = $(elem);
    var id_exercise = jElem.siblings('input[name="id_exercise"]').val();
    if(id_exercise !== undefined && id_exercise > 0){
        var query = 'del_ex=&id_exercise=' + id_exercise;
        $('div.exercise input[value="' + id_exercise  + '"]').parent().remove();
        $.ajax({
            type: 'POST',
            url: '/resp/' + query,
            data: query,
            success: function(data){
                var result = JSON.parse(data);
                if(result) {
                    $('div.container_add_ex').remove();
                    $('#exercise_bank').append('<div class="container_add_ex">');
                    $.each(result, function(id_exercise, str) {
                        addNewEx(str, id_exercise);
                    });
                    setDraggable();
                }
                else{

                }


            }
        });
    }
}

function setDraggable(){
    $('.container_add_ex .exercise').draggable({
        connectToSortable: '.exercises_container',
        helper: "clone",
        start: function() {
            onStartDrag();
        },
        stop: function() {   
            onStopDrag();
        }
    });
}
function createExercise(elem, id, ex, count, repeat){
    elem.append(
                '<div class="exercise" style="display: inline-block;">'
                + '<input type="hidden" value="' + id + '" name="id_exercise">'   
                + '<span class="ex">' + ex + '</span>'
                + '<span class="counts">' + count + '</span>'
                + '<div class="pd_btn plus" onclick="plus_counts(this)"></div>'
                + '<div class="pd_btn deg" onclick="deg_counts(this)"></div>'
                + '<span> X </span>'
                + '<span class="repeat">' + repeat + '</span>'
                + '<div class="pd_btn plus" onclick="plus_rep(this)"></div>'
                + '<div class="pd_btn deg" onclick="deg_rep(this)"></div>'
                + '</div>'
            );
}



