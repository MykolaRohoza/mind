<?php
?>


    <div class="container">
        
             <div class="row">
        <div class="col-sm-7">
            <?php if(count($images) > 0):?>
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false">
                <div class="carousel-inner" role="listbox">
                    <?php for($i = 0; $i < count($images); $i++): ?>
                        <div class="item <?php if($i==0) {echo 'active';} ?>">
                            <img src="<?=$images[$i]['path'];?>" alt="<?=$images[$i]['alt'];?>" onclick="put(this)">
                        </div>
                    <?php endfor; ?>

                </div>
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-menu-left glyphicon1" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-menu-right glyphicon1" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        <?php endif; ?>
        </div>
        </div>
        <div class="row">
            <div class="col-sm-9">

            
                <ul class="contacts">
            <?php if($users):?> 
            <?php foreach ($users as $user):?>                   
                <li class="clearfix">

                    <div class="user_card">
                        <div class="more">
                            <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
                        </div>
                        <img class="photo" src="<?='http://' . $_SERVER['SERVER_NAME'] . '/images/carousel/' . $user['article_img_name']?>" alt="<?=$user['image_alt']?>">
                        <h4><?=$user['user_name']?> <?=$user['user_second_name']?></h4>
                        <h4>Контакты: <?=$user['login']?>, Телефон <?=$user['telephone']?></h4>
                        <div class="diagnosis"><span class="diagnosis">Диагноз: <?=$user['diagnosis']?> </span> <div class="pd_btn plus" onclick="change_diagnosis(this)"></div></div>

                        
                        <div class="full_container"> <h4>Упражнения:</h4>
                                <div class="exercises_container"><?=$user['exercises']?></div>
                            <form class="exercises">
                                <input type="hidden" value="<?=$user['id_user']?>" name="id_user">
                                <textarea style="display:none" name="exercises"></textarea>
                                <input type="button" style="width: 25%;" class="btn btn-primary btn-block" name="exercise" value="Сохранить">
                            </form>
                        </div> 
                    </div>
     
                </li>
            <?php endforeach;?>
            <?php endif;?>                     
                        </div>

  
                    <div class="col-sm-3" style="padding:0px" id="exercise_bank">
                    <h4>Упражнения: </h4>
                    <input type="text" name="new_ex" class="form-control">
                    <input type="button" value="добавить" class="btn btn-primary btn-block"  name="add_ex">
                    <h5>Список упражнений:</h4>
                    <div class="container_add_ex">  
                    <?php foreach ($exercises as $id_exercise => $exercise):?>    
                        <div class="exercise">
                            <input type="hidden" name="id_exercise"  value="<?=$id_exercise?>">
                            <span class="ex"><?=$exercise?></span>
                            <div class="pd_btn deg" onclick="deg_ex(this)"></div>
                        </div> 
                    <?php endforeach;?>
                </div>  
            </div>                  
            </div>


    <script type="text/javascript">

    </script> 
                 
