<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post">
                    <div class="post-thumb">
                        <a href="<?= \yii\helpers\Url::toRoute(['site/view', 'id' => $article->id]) ?>">
                            <img src="<?= $article->getImage(); ?>" alt="">
                        </a>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6>
                                <a href="<?= \yii\helpers\Url::toRoute(['site/category', 'id' => $article->category->id]) ?>">
                                    <?= $article->category->title; ?>
                                </a>
                            </h6>

                            <h1 class="entry-title">
                                <a href="<?= \yii\helpers\Url::toRoute(['site/view', 'id' => $article->id]) ?>"><?= $article->title; ?></a>
                            </h1>


                        </header>
                        <div class="entry-content">
                            <p><?= $article->content; ?></p>
                        </div>

                        <div class="decoration">
                            <?php foreach ($article->tags as $tag):?>
                                <a href="#" class="btn btn-default"><?= $tag->title;?></a>
                            <?php endforeach;?>
                        </div>

                        <div class="social-share">
							<span class="social-share-title pull-left text-capitalize">
                                By <?= $article->author->name; ?> <?= $article->getDate(); ?>
                            </span>
                            <ul class="text-center pull-right">
                                <li><a class="s-vk" href="#"><i class="fa fa-vk"></i></a></li>
                                <li><a class=fa-android" href="#"><i class="fa fa-android"></i></a></li>
                                <li><a class=fa-youtube" href="#"><i class="fa fa-youtube"></i></a></li>
                                <li><a class=fa-github" href="#"><i class="fa fa-github"></i></a></li>
                                <li><a class=fa-chrome" href="#"><i class="fa fa-chrome"></i></a></li>
                                <li><a class=fa-windows" href="#"><i class="fa fa-windows"></i></a></li>
                                <li><a class=fa-google" href="#"><i class="fa fa-google"></i></a></li>
                                <li><a class=fa-steam" href="#"><i class="fa fa-steam"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </article>

                <!--bottom comment-->
                <?php if(!empty($comments)):?>
                    <?php foreach ($comments as $comment):?>
                        <div class="bottom-comment">
                            <div class="comment-img">
                                <img class="img-circle" src="<?= $comment->user->image; ?>" style="width: 100px">
                            </div>

                            <div class="comment-text">
                                <a href="#" class="replay btn pull-right"> Replay</a>
                                <h5><?= $comment->user->name; ?></h5>
                                <p class="comment-date"><?= $comment->getDate(); ?></p>
                                <p class="para"><?= $comment->text; ?>.</p>
                            </div>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>
                <!-- end bottom comment-->

                <!--leave comment-->
                <?= $this->render('/partials/comment', compact('article','comments','commentForm')); ?>
                <!--end leave comment-->

            </div>
            <!-- sidebar-->
            <?= $this->render('/partials/sidebar', compact('popular', 'recent', 'categories')); ?>
            <!-- edn sidebar-->
        </div>
    </div>
</div>
<!-- end main content-->