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
            <div class="col-sm-12">
                <ul class="contacts">
            <?php if($users):?> 
            <?php foreach ($users as $user):?>                   
                <li class="clearfix">
                    <img class="photo" src="<?='http://' . $_SERVER['SERVER_NAME'] . '/images/carousel/' . $user['article_img_name']?>" alt="<?=$user['image_alt']?>">
                    <div>
                        <h4><?=$user['user_name']?> <?=$user['user_second_name']?></h4>
                        <h4>Контакты: <?=$user['user_name']?> <?=$user['user_second_name']?>, Телефон <?=$user['telephone']?></h4>
                        <h4>Диагноз: <?=$user['info_diagnosis']?> </h4>
                        <div class="exercises_container"> Упражнения:
                        <form class="exercises">
                            <div class="exercise">
                                <input type="text" value="упражнение">
                                <input type="text" value="<?=$user['id_user']?>" hidden="" name="id_user">
                                <input type="text" class="counts" value="30">
                                <input type="text" class="repeat" value="2">
                                <input type="button" class="plus" value="+">
                                <input type="button" class="deg" value="-">
                            </div>

                            <div class="exercise">
                                <input type="text" value="упражнение">
                                <input type="text" value="<?=$user['id_user']?>" hidden="" name="id_user">
                                <input type="text" class="counts" value="30">
                                <input type="text" class="repeat" value="2">
                                <input type="button" class="plus" value="+">
                                <input type="button" class="deg" value="-">
                            </div>

                            <div class="exercise">
                                <input type="text" value="упражнение">
                                <input type="text" value="<?=$user['id_user']?>" hidden="" name="id_user">
                                <input type="text" class="counts" value="30">
                                <input type="text" class="repeat" value="2">
                                <input type="button" class="plus" value="+">
                                <input type="button" class="deg" value="-">
                            </div>
                            <input type="submit" name="exercise">
                        </form>
                        <div>
                        
                        
                        <!--                            <ul>
                            <li>Mail</li>
                            <li>Skype</li>
                            <li>Telephone</li>
                        </ul>-->
                    </div>
                </li>
            <?php endforeach;?>
            <?php endif;?>                     
                    <li class="clearfix">
                        <img class="photo" src="" alt="">
                        <div>
                            <h4>Виолета Бережная</h4>
<!--                            <ul>
                                <li>Mail</li>
                                <li>Skype</li>
                                <li>Telephone</li>
                            </ul>-->
                        </div>
                    </li>
                </ul>

            </div>
        </div>                  
    </div>

