<?php
use kartik\select2\Select2;
use yii\easyii2\widgets\Redactor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use grozzzny\widgets\switch_checkbox\SwitchCheckbox;

$module = $this->context->module->id;
?>

<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
]); ?>

<?= $this->render('@easyii2/views/fast/_image_file', ['model' => $model, 'attribute' => 'image_file'])?>
<?= $form->field($model, 'image_file')->fileInput() ?>

<?= $form->field($model, 'name') ?>

<?=$form->field($model, 'users')->widget(Select2::className(),[
    'data' => ArrayHelper::map($model->users, 'id', 'email'),
    'pluginOptions' => [
        'placeholder' => Yii::t('gr', 'Select users..'),
        'allowClear' => true,
        'multiple' => true,
        'ajax' => [
            'url' => '/admin/companies/ajax/get-users',
            'dataType' => 'json',
            'data' => new JsExpression('function(params) {
               return {
                    q:params.term
                };
            }'),
        ],
    ],
]);
?>

<?=$form->field($model, 'admins')->widget(Select2::className(),[
    'data' => ArrayHelper::map($model->users, 'id', 'email'),
    'pluginOptions' => [
        'placeholder' => Yii::t('gr', 'Select users..'),
        'allowClear' => true,
        'multiple' => true,
        'ajax' => [
            'url' => '/admin/companies/ajax/get-users',
            'dataType' => 'json',
            'data' => new JsExpression('function(params) {
               return {
                    q:params.term
                };
            }'),
        ],
    ],
]);
?>

<?= $form->field($model, 'country') ?>
<?= $form->field($model, 'city') ?>
<?= $form->field($model, 'address') ?>
<?= $form->field($model, 'phone') ?>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'site') ?>

<?= $form->field($model, 'description')->widget(Redactor::className(),[
    'options' => [
        'minHeight' => 200,
        'imageUpload' => Url::to(['/admin/redactor/upload', 'dir' => Yii::$app->controller->module->id]),
        'fileUpload' => Url::to(['/admin/redactor/upload', 'dir' => Yii::$app->controller->module->id]),
        'plugins' => ['fullscreen']
    ]
])?>

<?=SwitchCheckbox::widget([
    'model' => $model,
    'attributes' => [
        'status'
    ]
])?>

<?= Html::submitButton(Yii::t('easyii2', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>