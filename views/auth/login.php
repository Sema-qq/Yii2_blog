<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="site-login">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="col-md-10">

            <p>Please fill out the following fields to login:</p>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-md-4\">{input}</div>\n<div class=\"col-md-7\">{error}</div>",
                    'labelOptions' => ['class' => 'col-md-1 control-label'],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"col-md-offset-1 col-md-4\">{input} {label}</div>\n<div class=\"col-md-7\">{error}</div>",
            ]) ?>

            <div class="form-group">
                <div class="col-md-offset-1 col-md-11">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <div class="col-md-offset-1" style="color:#999;">
                You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
                To modify the username/password, please check out the code <code>app\models\User::$users</code>.
            </div>
        </div>
        <div class="col-md-2">
            <script type="text/javascript" src="//vk.com/js/api/openapi.js?152"></script>
            <script type="text/javascript">
                VK.init({apiId: 5966834});
            </script>

            <!-- VK Widget -->
            <div id="vk_auth"></div>
            <script type="text/javascript">
                VK.Widgets.Auth("vk_auth", {"authUrl":"/auth/login-vk"});
            </script>
        </div>


    </div>
    <br><br>
</div>
