<?php 
?>       
<div class="container">
    <div class="row">
        <div class="col-sm-12">

            <div class="article article-left clearfix">
               
                <?php if($isActive):?>
                    <p style="font-size:22px; color:green;">Спасибо, что за регестрировались на нашем сайте теперь вы можете использовать свой логин и пароль!</p>
                <?php endif; ?>
                <?php if(!$isActive): ?>
                    <p>Код регистрации просрочен либо просто отсутствует</p>
                    <form>
                        <label>Вставьте код регистрации <input type="text" size="30" name="code"></label>
                        <input type="submit" name="code_btn">
                    </form>
                <?php endif;?>
            </div>
        </div>
    </div>                  
</div>