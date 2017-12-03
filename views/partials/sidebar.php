<!-- sidebar-->
<div class="col-md-4" data-sticky_column>
    <div class="primary-sidebar">
        <!-- популярные посты , сортируются по просмотрам-->
        <aside class="widget">
            <h3 class="widget-title text-uppercase text-center">Popular Posts</h3>
            <?php foreach ($popular as $p): ?>
                <div class="popular-post">
                    <a href="<?= \yii\helpers\Url::toRoute(['site/view', 'id' => $p->id])?>" class="popular-img">
                        <img src="<?= $p->getImage(); ?>" alt="">
                        <div class="p-overlay"></div>
                    </a>
                    <div class="p-content">
                        <a href="<?= \yii\helpers\Url::toRoute(['site/view', 'id' => $p->id])?>" class="text-uppercase">
                            <?= $p->title; ?>
                        </a>
                        <span class="p-date"><?= $p->date; ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </aside>
        <!-- последние посты, сортируются по дате -->
        <aside class="widget pos-padding">
            <h3 class="widget-title text-uppercase text-center">Recent Posts</h3>
            <?php foreach ($recent as $r): ?>
                <div class="thumb-latest-posts">
                    <div class="media">
                        <div class="media-left">
                            <a href="<?= \yii\helpers\Url::toRoute(['site/view', 'id' => $r->id])?>" class="popular-img">
                                <img src="<?= $r->getImage(); ?>" alt="" style="width: 105px;">
                                <div class="p-overlay"></div>
                            </a>
                        </div>
                        <div class="p-content">
                            <a href="<?= \yii\helpers\Url::toRoute(['site/view', 'id' => $r->id])?>" class="text-uppercase">
                                <?= $r->title; ?>
                            </a>
                            <span class="p-date"><?= $r->date; ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </aside>
        <!-- категории -->
        <aside class="widget border pos-padding">
            <h3 class="widget-title text-uppercase text-center">Categories</h3>
            <ul>
                <?php foreach ($categories as $category): ?>
                    <li>
                        <a href="<?= \yii\helpers\Url::toRoute(['site/category', 'id' => $category->id])?>"><?= $category->title; ?></a>
                        <span class="post-count pull-right">
                                       (<?= $category->getArticles()->count(); ?>)
                                   </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>
    </div>
</div>
<!-- edn sidebar-->