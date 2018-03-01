<?php

use yii\db\Migration;

/**
 * Handles adding date to table `comment`.
 */
class m180301_160622_add_date_column_to_comment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('comment', 'date', $this->date());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('comment', 'date');
    }
}
