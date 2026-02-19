<?php

/**
 * @var string $content
 * @var View $this
 */

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Breadcrumbs;

$this->registerAssetBundle('app\assets\AppAsset');
/** @noinspection JSDeprecatedSymbols */
$jsText = <<<JS
    $(".nav.side-menu > li > a").click(function(e){
        if($(this).parent().children('ul').length > 0){
            e.preventDefault();
            return false;
        }
    })
    
    $(document).on('select2:open', () => {
        document.querySelector('.select2-container--open .select2-search__field').focus();
    });
JS;

$this->registerJs($jsText, View::POS_READY);

$css = <<< CSS
    .nav.side-menu > li.active > a {
        background: #152935;
    }
    .right-nav-block>li:not(:first-child) {
        padding-left: 20px;
    }
    @media (max-width: 550px) {
        .right-nav-block>li:not(:first-child) {
          padding-left: 0;
        }
    }
CSS;

$this->registerCss($css);

$style = <<<CSS
    .left_col, .nav_title , #support-link{
        background: cornflowerblue;
    }
    .nav.side-menu > li.active > a {
        background: cornflowerblue;
    }
    
CSS;

$this->registerCss($style);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<?php $this->beginBody(); ?>
<div class="container body">
    <div class="main_container">
        <div class="row">
            <div class="col-md-3">
                <div class="left_col scroll-view">
                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul>
                                <li>
                                    <a href="/students">Студенты</a>
                                </li>
                                <li>
                                    <a href="/specialisation">Специальности</a>
                                </li>
                                <li>
                                    <a href="/group">Группы</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

            <!-- page content -->
            <div class="col-md-9 right_col" role="main">

                <div class="x_panel">
                    <div class="x_title">
                        <h1><?= Html::encode($this->title) ?></h1>
                    </div>
                    <div class="x_content">
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<!-- /footer content -->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
