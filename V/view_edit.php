<?php
            
?>
<div class="container">
        <div class="row">
        <div class="col-sm-12">
        </div></div>
        
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
            <strong class="logo"><a href="#">MB</a></strong>
        </div>
                <div class="col-sm-5">

            <form method="post" enctype="multipart/form-data">
                <span id="message"><?=$message_file?></span>
                <input type='file' name='img'>
                Задать название
                <input type="text" name="name">
                <input type="text" name="old_name" style="display: none;">
                Задать описание
                <input type="text" name="alt">
                <label>Показывать в слайдере <input type="checkbox" name='image_show' checked="checked"></label><br>
                <input type="submit" name='upload_img' value="Отправить">
                <input type="submit" name='delete_img' value="Удалить">
                <input type="hidden" value="<?=$id_article?>" name='id_article'>
            </form>
            <br>
            <br> 
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
        
               
            <div class="article article-left" id='changeWrap1'>
                <div class="editor">

                    Вид статьи<select name='article_func'>
                            <option value="1" <?php if($article_func == 1){echo 'selected="selected"';} ?>>Акция</option>
                            <option value="2" <?php if($article_func == 2){echo 'selected="selected"';} ?>>Статья</option>
<!--                            <option value="3"<?php if($article_func == 3){echo 'selected="selected"';} ?>>Тема</option>
                            <option value="4"<?php if($article_func == 4){echo 'selected="selected"';} ?>>Подстатья</option>-->
                        </select>
                        
<!--          
                        Подстатья для <select name='secondary_to'>
                            <?php foreach ($tops as $id => $sec_to):?>
                                <option value="<?=$id?>" <?php if($id == $secondary_to) {echo 'selected="selected"';}?>><?=$sec_to?></option>
                            <?php endforeach;?>
                           
                        </select>
                        <br>
               -->
                        Назначение <select name='article_dest'>
                            <option value="1"  <?php if($article_dest == 1){echo 'selected="selected"';} ?>>Главная</option>
                            <option value="2" <?php if($article_dest == 2){echo 'selected="selected"';} ?>>Профилактор</option>
                            <option value="3" <?php if($article_dest == 3){echo 'selected="selected"';} ?>>Статьи</option>
                        </select>
            

                        Размещение фото <select name='article_img_place'>
                            <option value="none" <?php if($article_img_place == 'none'){echo 'selected="selected"';} ?>>Без фото</option>
                            <option value="top" <?php if($article_img_place == 'top'){echo 'selected="selected"';} ?>>Вверху</option>
                            <option value="left" <?php if($article_img_place == 'left'){echo 'selected="selected"';} ?>>Слева</option>
                            <option value="right" <?php if($article_img_place == 'right'){echo 'selected="selected"';} ?>>Справа</option>
                        </select>
                </div>

                <br>
                <div>
                    <ul>
                        <li><a href="/edit/"><b>+</b> Добавить статью</a></li>
                   <?php foreach ($article_list as $article) :?>
                        <li><a href="/edit/<?=$article['id_article']?>"><b>№<?=$article['id_article']?></b> <?=$article['article_title']?></a></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>       
        </div>
        <div class="col-sm-6">

               
            <div class="article article-left" id='changeWrap'>
                <div class="editor">
                    
                <form method="post">
                    <input type="hidden" value="<?=$id_article?>" name='id_article'>
                    <input type="hidden" value="" name='article_func'>    
                    <input type="hidden" value="" name='secondary_to'>    
                    <input type="hidden" value="" name='article_dest'>     
                    <input type="hidden" value="<?=$article_img_name;?>" name='article_img_name'>
                    <input type="hidden" value="<?=$article_img_place;?>" name='article_img_place'>     
                    <input type="text" value="<?=$article_title;?>" style="font-weight: 600;" name='article_title'>
                    <br>
                    <br>
                    <textarea style="width: 100%; resize: none;" id="change"><?=$article_text;?></textarea>
                    <textarea style="width: 100%; display: none;" id="hidden_change" name='article_text'></textarea>
                    <input type="submit" value="Создать/Сохранить изменения" name='save'>
                    <input type="submit" value="Удалить" name='delete'>
                </form>
                </div>
            </div>
        </div>       
        <div class="col-sm-6">

               
            <div class="article article-left" id="view_article">
               
                <h3 id='v_h3'></h3>

                <img id="article_img" <?php if(!$article_img_name){echo 'style="display:none;"';}?>  src="" alt="">
                <div id='v_content'>
                </div>
            </div>
        </div>
        



    </div>                  
