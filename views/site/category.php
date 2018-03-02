<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php foreach ($articles as $article): ?>
                    <article class="post post-list">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="post-thumb">
                                    <a href="<?=\yii\helpers\Url::toRoute(['view/single', 'id' => $article->id])?>">
                                        <img src="<?= $article->getImage(); ?>" alt="" class="pull-left">
                                    </a>
                                    <a href="<?=\yii\helpers\Url::toRoute(['view/single', 'id' => $article->id])?>" class="post-thumb-overlay text-center">
                                        <div class="text-uppercase text-center">View Post</div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="post-content">
                                    <header class="entry-header text-uppercase">
                                        <h6><a href="#"> <?= $article->category->title; ?></a></h6>
                                        <h1 class="entry-title">
                                            <a href="<?= \yii\helpers\Url::toRoute(['site/category', 'id' => $article->category_id])?>">
                                                <?= $article->title; ?>
                                            </a>
                                        </h1>
                                    </header>
                                    <div class="entry-content">
                                        <p><?= $article->description; ?></p>
                                    </div>
                                    <div class="social-share">
                                        <span class="social-share-title pull-left text-capitalize">
                                            By <?= $article->author->name; ?> On <?= $article->getDate(); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>

                <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>
            </div>
            <!-- sidebar-->
            <?= $this->render('/partials/sidebar', compact('popular', 'recent', 'categories'));?>
            <!-- edn sidebar-->
        </div>
    </div>
</div>
<!-- end main content-->