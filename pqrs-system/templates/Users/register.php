<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Registro de Usuario');
?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header text-center">
                <h4><i class="fas fa-user-plus"></i> Registro de Usuario</h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($user) ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <?= $this->Form->text('first_name', [
                                'class' => 'form-control',
                                'placeholder' => 'Nombres',
                                'required' => true
                            ]) ?>
                            <?= $this->Form->label('first_name', 'Nombres') ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <?= $this->Form->text('last_name', [
                                'class' => 'form-control',
                                'placeholder' => 'Apellidos',
                                'required' => true
                            ]) ?>
                            <?= $this->Form->label('last_name', 'Apellidos') ?>
                        </div>
                    </div>
                </div>
                
                <div class="form-floating mb-3">
                    <?= $this->Form->email('email', [
                        'class' => 'form-control',
                        'placeholder' => 'correo@ejemplo.com',
                        'required' => true
                    ]) ?>
                    <?= $this->Form->label('email', 'Correo Electrónico') ?>
                </div>
                
                <div class="form-floating mb-3">
                    <?= $this->Form->tel('phone', [
                        'class' => 'form-control',
                        'placeholder' => 'Teléfono'
                    ]) ?>
                    <?= $this->Form->label('phone', 'Teléfono (Opcional)') ?>
                </div>
                
                <div class="form-floating mb-3">
                    <?= $this->Form->password('password', [
                        'class' => 'form-control',
                        'placeholder' => 'Contraseña',
                        'required' => true,
                        'minlength' => 6
                    ]) ?>
                    <?= $this->Form->label('password', 'Contraseña') ?>
                    <div class="form-text">Mínimo 6 caracteres</div>
                </div>
                
                <div class="d-grid">
                    <?= $this->Form->button('Registrarse', [
                        'class' => 'btn btn-success'
                    ]) ?>
                </div>
                
                <?= $this->Form->end() ?>
                
                <hr>
                
                <div class="text-center">
                    <p class="mb-0">¿Ya tienes cuenta?</p>
                    <?= $this->Html->link('Inicia sesión aquí', ['action' => 'login'], [
                        'class' => 'btn btn-outline-primary btn-sm'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>