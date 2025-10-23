<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pqr $pqr
 */
$this->assign('title', 'PQRS #' . $pqr->ticket_number);
$user = $this->getRequest()->getAttribute('identity');
?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <span class="badge bg-secondary me-2"><?= h($pqr->ticket_number) ?></span>
                    <?= h($pqr->subject) ?>
                </h5>
                <span class="badge <?= $pqr->getStatusBadgeClass() ?>">
                    <?= ucfirst(h($pqr->status)) ?>
                </span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Tipo:</strong> <?= $pqr->getTypeDisplayName() ?></p>
                        <p><strong>Categoría:</strong> <?= h($pqr->category->name) ?></p>
                        <p><strong>Prioridad:</strong> 
                            <span class="badge <?= $pqr->getPriorityBadgeClass() ?>">
                                <?= ucfirst(h($pqr->priority)) ?>
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Solicitante:</strong> <?= h($pqr->requester_name) ?></p>
                        <p><strong>Email:</strong> <?= h($pqr->requester_email) ?></p>
                        <?php if ($pqr->requester_phone): ?>
                            <p><strong>Teléfono:</strong> <?= h($pqr->requester_phone) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <hr>
                <h6>Descripción:</h6>
                <p><?= nl2br(h($pqr->description)) ?></p>
                
                <?php if ($user && in_array($user->role, ['admin', 'agent'])): ?>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Fecha de Creación:</strong> <?= $pqr->created->format('d/m/Y H:i') ?></p>
                            <?php if ($pqr->due_date): ?>
                                <p><strong>Fecha Límite:</strong> 
                                    <?= $pqr->due_date->format('d/m/Y') ?>
                                    <?php if ($pqr->isOverdue()): ?>
                                        <span class="badge bg-danger ms-1">Vencido</span>
                                    <?php endif; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <?php if ($pqr->assigned_agent): ?>
                                <p><strong>Agente Asignado:</strong> <?= h($pqr->assigned_agent->first_name . ' ' . $pqr->assigned_agent->last_name) ?></p>
                            <?php else: ?>
                                <p><strong>Agente Asignado:</strong> <span class="text-muted">Sin asignar</span></p>
                            <?php endif; ?>
                            <?php if ($pqr->resolved_at): ?>
                                <p><strong>Fecha de Resolución:</strong> <?= $pqr->resolved_at->format('d/m/Y H:i') ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Responses -->
        <?php if (!empty($pqr->pqrs_responses)): ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Respuestas y Seguimiento</h6>
                </div>
                <div class="card-body">
                    <?php foreach ($pqr->pqrs_responses as $response): ?>
                        <?php if (!$response->is_internal || ($user && in_array($user->role, ['admin', 'agent']))): ?>
                            <div class="card mb-3 <?= $response->is_internal ? 'border-warning' : '' ?>">
                                <div class="card-body">
                                    <?php if ($response->is_internal && $user && in_array($user->role, ['admin', 'agent'])): ?>
                                        <div class="alert alert-warning alert-sm mb-2">
                                            <i class="fas fa-lock"></i> Nota interna (solo visible para agentes)
                                        </div>
                                    <?php endif; ?>
                                    <p class="mb-2"><?= nl2br(h($response->response_text)) ?></p>
                                    <small class="text-muted">
                                        <i class="fas fa-user"></i> <?= h($response->user->first_name . ' ' . $response->user->last_name) ?> - 
                                        <i class="fas fa-clock"></i> <?= $response->created->format('d/m/Y H:i') ?>
                                    </small>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Add Response Form (for agents/admins) -->
        <?php if ($user && in_array($user->role, ['admin', 'agent']) && in_array($pqr->status, ['pending', 'in_progress'])): ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Agregar Respuesta</h6>
                </div>
                <div class="card-body">
                    <?= $this->Form->create(null, ['url' => ['controller' => 'PqrsResponses', 'action' => 'add', '?' => ['pqrs_id' => $pqr->id]]]) ?>
                    
                    <div class="form-floating mb-3">
                        <?= $this->Form->textarea('response_text', [
                            'class' => 'form-control',
                            'placeholder' => 'Escriba su respuesta...',
                            'required' => true,
                            'rows' => 4,
                            'style' => 'height: 100px'
                        ]) ?>
                        <?= $this->Form->label('response_text', 'Respuesta') ?>
                    </div>
                    
                    <div class="form-check mb-3">
                        <?= $this->Form->checkbox('is_internal', [
                            'class' => 'form-check-input'
                        ]) ?>
                        <?= $this->Form->label('is_internal', 'Nota interna (solo visible para agentes)', [
                            'class' => 'form-check-label'
                        ]) ?>
                    </div>
                    
                    <div class="form-check mb-3">
                        <?= $this->Form->checkbox('resolve_pqrs', [
                            'class' => 'form-check-input'
                        ]) ?>
                        <?= $this->Form->label('resolve_pqrs', 'Marcar como resuelto', [
                            'class' => 'form-check-label'
                        ]) ?>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <?= $this->Form->button('Enviar Respuesta', [
                            'class' => 'btn btn-primary'
                        ]) ?>
                    </div>
                    
                    <?= $this->Form->end() ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Sidebar -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Acciones</h6>
            </div>
            <div class="card-body">
                <?= $this->Html->link('<i class="fas fa-arrow-left"></i> Volver a la Lista', 
                    ['action' => 'index'], 
                    ['class' => 'btn btn-secondary btn-sm mb-2 w-100', 'escape' => false]) ?>
                
                <?php if ($user && in_array($user->role, ['admin', 'agent'])): ?>
                    <?php if (!$pqr->assigned_agent_id || ($user->role === 'admin')): ?>
                        <?= $this->Html->link('<i class="fas fa-user-plus"></i> Asignar Agente', 
                            ['action' => 'assign', $pqr->id], 
                            ['class' => 'btn btn-success btn-sm mb-2 w-100', 'escape' => false]) ?>
                    <?php endif; ?>
                    
                    <?= $this->Html->link('<i class="fas fa-edit"></i> Editar PQRS', 
                        ['action' => 'edit', $pqr->id], 
                        ['class' => 'btn btn-warning btn-sm mb-2 w-100', 'escape' => false]) ?>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Información del Estado</h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Estado Actual:</strong><br>
                    <span class="badge <?= $pqr->getStatusBadgeClass() ?>">
                        <?= ucfirst(h($pqr->status)) ?>
                    </span>
                </div>
                
                <div class="mb-2">
                    <strong>Prioridad:</strong><br>
                    <span class="badge <?= $pqr->getPriorityBadgeClass() ?>">
                        <?= ucfirst(h($pqr->priority)) ?>
                    </span>
                </div>
                
                <?php if ($pqr->due_date): ?>
                    <div class="mb-2">
                        <strong>Vence:</strong><br>
                        <?= $pqr->due_date->format('d/m/Y') ?>
                        <?php if ($pqr->isOverdue()): ?>
                            <br><span class="badge bg-danger">Vencido</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <div class="mb-2">
                    <strong>Creado:</strong><br>
                    <?= $pqr->created->format('d/m/Y H:i') ?>
                </div>
                
                <?php if ($pqr->resolved_at): ?>
                    <div class="mb-2">
                        <strong>Resuelto:</strong><br>
                        <?= $pqr->resolved_at->format('d/m/Y H:i') ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>