<?php echo $this->setPageTitle($title); ?>
<h2><?=$title?></h2>
 
<div class="form col-lg-10">
    <?php
    //Formulario con validación en frontend y backend
    $form=$this->beginWidget('CActiveForm',array(
        "method"=>"POST",
        "action"=>"",
        "enableClientValidation"=>true,
        "clientOptions"=>array(
            "validateOnSubmit"=>true,
            "validateOnChange"=>true,
            "validateOnType"=>true
        )
    )); ?>
    
        <?php echo $form->errorSummary($model); ?>
    
        <div class="row">
            <?php echo $form->label($model,'nombre'); ?>
            <?php
                if(isset($patrocinador)){
                    echo $form->textField($model,'nombre',
                    array("class"=>"form-control","value"=>$patrocinador["nombre"]));
                }else{
                    echo $form->textField($model,'nombre',
                                    array("class"=>"form-control"));
                }
            ?>
            <?php echo $form->error($model,'nombre') ?>
        </div>
        
        <div class="row">
            <?php echo $form->label($model,'apellido'); ?>
            <?php
                if(isset($patrocinador)){
                    echo $form->textField($model,'apellido',
                array("class"=>"form-control","value"=>$patrocinador["apellido"]));
                }else{
                    echo $form->textField($model,'apellido',
                            array("class"=>"form-control"));
                }
            ?>
            <?php echo $form->error($model,'apellido') ?>
        </div>
        
        <div class="row">
            <?php echo $form->label($model,'email'); ?>
            <?php
                if(isset($patrocinador)){
                    echo $form->emailField($model,'email',
                    array("class"=>"form-control","value"=>$patrocinador["email"]));
                }else{
                    echo $form->emailField($model,'email',
                                    array("class"=>"form-control"));
                }
            ?>
            <?php echo $form->error($model,'email') ?>
        </div>
        
        <div class="row">
            <?php echo $form->label($model,'password'); ?>
            <?php
                if(isset($patrocinador)){
                    echo $form->textField($model,'password',
                array("class"=>"form-control","value"=>$patrocinador["password"]));
                }else{
                    echo $form->textField($model,'password',
                        array("class"=>"form-control"));
                }
            ?>
            <?php echo $form->error($model,'password') ?>
        </div>
    <br/>
        <div class="row submit">
            <?php echo Chtml::submitButton('Guardar', array("class"=>"btn btn-success")); ?>
        </div>
    
    <?php $this->endWidget(); ?>
</div><!-- form -->
