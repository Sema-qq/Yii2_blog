<?php if(!Yii::$app->user->isGuest):?>
    <div class="leave-comment">
        <h4>LEAVE A REPLAY</h4>
        <?php if(Yii::$app->session->getFlash('comment')):?>
            <div class="alert alert-success" role="alert">
                <?= Yii::$app->session->getFlash('comment');?>
            </div>
        <?php endif;?>
        <?php $form = \yii\widgets\ActiveForm::begin([
            'action' => ['site/comment', 'id' => $article->id],
            'options' => ['class' => 'form-horizontal contact-form', 'role' => 'form']
        ])?>
        <div class="form-group">
            <div class="col-md-12" style="border-radius: 10px">
                <?= $form->field($commentForm, 'comment')->textarea([
                    'class' => 'form-control',
                    'placeholder' => 'Enter message',
                    'style' => 'width: 96.5%; margin-left:2%'
                ])->label(false)?>
            </div>
        </div>
        <button type="submit" class="btn send-btn">POST COMMENT</button>
        <?php \yii\widgets\ActiveForm::end();?>
    </div>
<?php endif;?>