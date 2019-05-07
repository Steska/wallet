<?php
/**
 * @var \common\models\Currency[] $currencies
 * @var \common\models\Wallet $model
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Create new wallat';
?>
<div class="currency-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
