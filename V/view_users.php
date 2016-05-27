<?php
?>
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <?php if($articles):?> 
            <?php foreach ($users as $user):?>
                <div class="article article-left clearfix">
                    <h3><?=$user['article_title']?></h3>
                    <img src="<?='http://' . $_SERVER['SERVER_NAME'] . '/images/carousel/' . $user['article_img_name']?>" alt="<?=$user['image_alt']?>">
                        <?php if($isAdmin):?>
                            <a href="/edit/<?=$user['id_article']?>" class=" edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                        <?php endif;?>

                <?=$user['article_text']?>
                </div>
            <?php endforeach;?>
            <?php endif;?>       
        </div>

<?=$stocks;?>
    </div>                  
</div>


    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <ul class="contacts">
            <?php if($users):?> 
            <?php foreach ($users as $user):?>                   
                <li class="clearfix">
                    <img class="photo" src="<?='http://' . $_SERVER['SERVER_NAME'] . '/images/carousel/' . $user['article_img_name']?>" alt="<?=$user['image_alt']?>">
                    <div>
                        <h4><?=$user['id_article']?></h4>
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

