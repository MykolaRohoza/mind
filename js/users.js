$(function() {
    $('.exercises_container').sortable({
        delay: 250,
        start: function() {
        },
        stop: function() {
            
        }
        
    });  
    
    setDraggable(); 
    $('input[name="add_ex"]').on('click', function (){
        addNewEx($('input[name="new_ex"]').val().trim());
        addNewExGetAll($('input[name="new_ex"]').val().trim());
    });

});
function onStopDrag(){
    $('.exercises_container div.ui-draggable div').remove();
    var cont = $('.exercises_container div.ui-draggable').removeAttr('class');
    cont.addClass('exercise').append(
                            '<span class="counts">30</span>'
                            + '<div class="pd_btn plus" onclick="plus_counts(this)"></div>'
                            + '<div class="pd_btn deg" onclick="deg_counts(this)"></div>'
                            + '<span class="counts"> X </span>'
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
    if(str !== undefined && str.trim().length > 0){
        // Добавить проверку на номер
        id_exercise = (id_exercise === undefined)?0:id_exercise;
        $('div.container_add_ex').remove();
        $('.col-sm-2').append('<div class="container_add_ex">');
        $('div.container_add_ex').append(
                '<div class="exercise ui-draggable">'
                + '<input type="hidden" name="id_exercise"  value="' + id_exercise + '">'
                + '<span class="ex">' + str + '</span>'
                + '<div class="pd_btn deg" onclick="deg_counts(this)"></div>'
                + '</div>'
        );
        setDraggable();
    }
}
function addNewExGetAll(str){
    if(str !== undefined && str.trim().length > 0){
    var query = 'add_new_ex=' + str;
    $.ajax({
        type: 'POST',
        url: '/resp/' + query,
        data: query,
        success: function(data){
        console.log(data);
            var result = JSON.parse(data);
            if(result) {

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


