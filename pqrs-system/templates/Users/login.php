<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Iniciar Sesión');
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header text-center">
                <h4><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create() ?>
                
                <div class="form-floating mb-3">
                    <?= $this->Form->email('email', [
                        'class' => 'form-control',
                        'placeholder' => 'correo@ejemplo.com',
                        'required' => true
                    ]) ?>
                    <?= $this->Form->label('email', 'Correo Electrónico') ?>
                </div>
                
                <div class="form-floating mb-3">
                    <?= $this->Form->password('password', [
                        'class' => 'form-control',
                        'placeholder' => 'Contraseña',
                        'required' => true
                    ]) ?>
                    <?= $this->Form->label('password', 'Contraseña') ?>
                </div>
                
                <div class="d-grid">
                    <?= $this->Form->button('Iniciar Sesión', [
                        'class' => 'btn btn-primary'
                    ]) ?>
                </div>
                
                <?= $this->Form->end() ?>
                
                <hr>
                
                <div class="text-center">
                    <p class="mb-0">¿No tienes cuenta?</p>
                    <?= $this->Html->link('Regístrate aquí', ['action' => 'register'], [
                        'class' => 'btn btn-outline-secondary btn-sm'
                    ]) ?>
                </div>
            </div>
        </div>
        
        <div class="mt-4 text-center">
            <div class="card">
                <div class="card-body">
                    <h6>Usuarios de Prueba:</h6>
                    <small class="text-muted">
                        <strong>Admin:</strong> admin@pqrs.com / password<br>
                        <strong>Agente:</strong> agente@pqrs.com / password<br>
                        <strong>Usuario:</strong> usuario@pqrs.com / password
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>