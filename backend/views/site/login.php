<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\Backend_login */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';

?>
<body class="login">
<div>
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form action="/login" method="post">
                    <h1>Login Form</h1>
                    <?php echo Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), []);?>
                    <div>
                        <input type="text" name="Authorize[username]" class="form-control" placeholder="Логин" required="" />
                    </div>
                    <div>
                        <input type="password" name="Authorize[password]" class="form-control" placeholder="Пароль" required="" />
                    </div>
                    <div>
                        <input type="password" value="1" style="display: none" name="Authorize[rememberMe]" class="form-control" placeholder="rememberMe" required="" />
                    </div>
                    <div>
                        <input type="submit"  value="Войти" class="btn btn-default submit">
                    </div>
                    <div class="clearfix"></div>

                    <div class="separator">
                        <div class="clearfix"></div>
                        <br />

                        <div>
                            <h1><i class="fa fa-paw"></i> Surprise.im!</h1>
                            <p>©2016 All Rights Reserved. Surprise.im Admin</p>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
</body>
