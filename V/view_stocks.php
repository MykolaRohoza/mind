<?php foreach($stocks as $stock): ?>
    <div class="col-sm-4">
        <?php if($isAdmin):?>
            <a href="/edit/<?=$stock['id_article'];?>" class=" edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
        <?php endif;?>
        <div class="advertise">
            <h3><?=$stock['article_title'];?></h3>
            <p> <?=$stock['article_text'];?></p>
            <hr/>
        </div>    
    </div>
<?php endforeach;


