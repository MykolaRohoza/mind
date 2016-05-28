$(function() {
    var obj;
    $('.exercises_container').sortable({
        delay: 250,
        start: function() {
        },
        stop: function() {
            
        }
        
    });  
    
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

});
function onStopDrag(){
    $('.exercises_container div.ui-draggable').removeAttr('class').addClass('exercise');
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
