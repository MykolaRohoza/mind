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
        <div class="row">
            <div class="col-sm-10">
                <ul class="contacts">
            <?php if($users):?> 
            <?php foreach ($users as $user):?>                   
                <li class="clearfix">
                    <img class="photo" src="<?='http://' . $_SERVER['SERVER_NAME'] . '/images/carousel/' . $user['article_img_name']?>" alt="<?=$user['image_alt']?>">
                    <div>
                        <h4><?=$user['user_name']?> <?=$user['user_second_name']?></h4>
                        <h4>Контакты: <?=$user['user_name']?> <?=$user['user_second_name']?>, Телефон <?=$user['telephone']?></h4>
                        <h4>Диагноз: <?=$user['info_diagnosis']?> </h4>
                        
                        <div class="full_container"> <h4>Упражнения:</h4>
                            <div class="exercises_container">


                            <div class="exercise">


                                <span class="ex">упражнение</span>
                                <span class="counts">30</span>
                                <div class="pd_btn plus" onclick="plus(this)"></div>
                                <div class="pd_btn deg" onclick="deg(this)"></div>
                                <span class="counts"> X </span>
                                <span class="repeat">2</span>
                                <div class="pd_btn plus" onclick="plus(this)"></div>
                                <div class="pd_btn deg" onclick="deg(this)"></div>
                            </div>
                            <div class="exercise">


                                <span class="ex">упражнение</span>
                                <span class="counts">30</span>
                                <div class="pd_btn plus" onclick="plus(this)"></div>
                                <div class="pd_btn deg" onclick="deg(this)"></div>
                                <span class="counts"> X </span>
                                <span class="repeat">2</span>
                                <div class="pd_btn plus" onclick="plus(this)"></div>
                                <div class="pd_btn deg" onclick="deg(this)"></div>
                            </div>
                            <div class="exercise">


                                <span class="ex">упражнение</span>
                                <span class="counts">30</span>
                                <div class="pd_btn plus" onclick="plus(this)"></div>
                                <div class="pd_btn deg" onclick="deg(this)"></div>
                                <span class="counts"> X </span>
                                <span class="repeat">2</span>
                                <div class="pd_btn plus" onclick="plus(this)"></div>
                                <div class="pd_btn deg" onclick="deg(this)"></div>
                            </div>
                           

  
                    </div>
                        <br><form class="exercises">
                            <input type="hidden" value="<?=$user['id_user']?>" name="id_user">
                            <input type="submit" name="exercise">
                        </form>
                    </div>  
                </li>
            <?php endforeach;?>
            <?php endif;?>                     

            </div>
                    <div class="col-sm-2" style="padding:0px">
                    <h4>Упражнения: </h4>
                    <input type="text">
                    <input type="button" value="добьавить">
                    <h5>Список упражнений:</h4>
                    <div class="container_add_ex">  
                        <div class="exercise">
                            <span class="ex">упражнение</span>
                            <span class="counts">30</span>
                            <span class="counts"> X </span>
                            <span class="repeat">2</span>
                        </div>        
                </div>  
            </div>                  
    </div>

        </div>

    <script type="text/javascript">

    </script> 
                 
       
</div>