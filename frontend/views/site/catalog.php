<?php
use yii\helpers\Url;

$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1 class="m-b-30">Каталог</h1>

<section id="catalog">
    <?php foreach( $categories as $main_category_id => $category_subcategory ): ?>
        <div class="catalog-category">
            <a href="<?=Url::toRoute('site/catalog/'.$main_category_id) ?>"><h2 class="<?=$css_style_categories[$main_category_id] ?>-big"><?=$category_subcategory['name_category'] ?></h2></a>
            <div class="sub-category">
                <?php foreach( $category_subcategory['subcategories'] as $subcategories_id => $subcategories  ): ?>
                    <a href="<?=Url::toRoute('site/catalog/'.$subcategories_id) ?>"><?=$subcategories ?></a>
                <?php endforeach; ?>
            </div>
            <hr class="yellow-line m-t-30">
            <hr class="grey-line">
        </div>
    <?php endforeach; ?>
</section>

<style>

</style>

