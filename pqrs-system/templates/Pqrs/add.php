<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pqr $pqr
 * @var array $categories
 */
$this->assign('title', 'Crear PQRS');
$user = $this->getRequest()->getAttribute('identity');
?>

<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-plus-circle"></i> Crear Nueva PQRS</h4>
                <p class="mb-0 text-muted">Complete el formulario para enviar su Petición, Queja, Reclamo o Sugerencia</p>
            </div>
            <div class="card-body">
                <?= $this->Form->create($pqr) ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <?= $this->Form->select('type', [
                                'petition' => 'Petición',
                                'complaint' => 'Queja',
                                'claim' => 'Reclamo',
                                'suggestion' => 'Sugerencia'
                            ], [
                                'class' => 'form-select',
                                'required' => true,
                                'empty' => 'Seleccione el tipo'
                            ]) ?>
                            <?= $this->Form->label('type', 'Tipo de PQRS') ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <?= $this->Form->select('category_id', $categories, [
                                'class' => 'form-select',
                                'required' => true,
                                'empty' => 'Seleccione una categoría'
                            ]) ?>
                            <?= $this->Form->label('category_id', 'Categoría') ?>
                        </div>
                    </div>
                </div>
                
                <div class="form-floating mb-3">
                    <?= $this->Form->text('subject', [
                        'class' => 'form-control',
                        'placeholder' => 'Asunto',
                        'required' => true,
                        'maxlength' => 255
                    ]) ?>
                    <?= $this->Form->label('subject', 'Asunto') ?>
                </div>
                
                <div class="form-floating mb-3">
                    <?= $this->Form->textarea('description', [
                        'class' => 'form-control',
                        'placeholder' => 'Descripción detallada',
                        'required' => true,
                        'rows' => 5,
                        'style' => 'height: 120px'
                    ]) ?>
                    <?= $this->Form->label('description', 'Descripción') ?>
                </div>
                
                <?php if (!$user): ?>
                    <hr>
                    <h6>Información del Solicitante</h6>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <?= $this->Form->text('requester_name', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Nombre completo',
                                    'required' => true
                                ]) ?>
                                <?= $this->Form->label('requester_name', 'Nombre Completo') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <?= $this->Form->email('requester_email', [
                                    'class' => 'form-control',
                                    'placeholder' => 'correo@ejemplo.com',
                                    'required' => true
                                ]) ?>
                                <?= $this->Form->label('requester_email', 'Correo Electrónico') ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <?= $this->Form->tel('requester_phone', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Teléfono'
                                ]) ?>
                                <?= $this->Form->label('requester_phone', 'Teléfono (Opcional)') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <?= $this->Form->text('requester_id_number', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Número de identificación'
                                ]) ?>
                                <?= $this->Form->label('requester_id_number', 'Cédula/NIT (Opcional)') ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <?= $this->Form->select('priority', [
                                'low' => 'Baja',
                                'medium' => 'Media',
                                'high' => 'Alta',
                                'urgent' => 'Urgente'
                            ], [
                                'class' => 'form-select',
                                'value' => 'medium'
                            ]) ?>
                            <?= $this->Form->label('priority', 'Prioridad') ?>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <?= $this->Html->link('Cancelar', ['action' => 'index'], [
                        'class' => 'btn btn-secondary'
                    ]) ?>
                    <?= $this->Form->button('Enviar PQRS', [
                        'class' => 'btn btn-primary'
                    ]) ?>
                </div>
                
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>