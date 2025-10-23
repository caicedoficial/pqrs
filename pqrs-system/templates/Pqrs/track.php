<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pqr|null $pqr
 * @var string|null $ticketNumber
 */
$this->assign('title', 'Consultar PQRS');
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-search"></i> Consultar Estado de PQRS</h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create(null, ['type' => 'get']) ?>
                <div class="input-group mb-3">
                    <?= $this->Form->text('ticket', [
                        'class' => 'form-control',
                        'placeholder' => 'Ingrese el número de ticket (ej: PQRS20240001)',
                        'value' => $ticketNumber,
                        'required' => true
                    ]) ?>
                    <?= $this->Form->button('Consultar', [
                        'class' => 'btn btn-primary',
                        'type' => 'submit'
                    ]) ?>
                </div>
                <?= $this->Form->end() ?>
                
                <?php if ($pqr): ?>
                    <hr>
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
                            <div class="row">
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
                                    <p><strong>Fecha de Creación:</strong> <?= $pqr->created->format('d/m/Y H:i') ?></p>
                                    <?php if ($pqr->due_date): ?>
                                        <p><strong>Fecha Límite:</strong> 
                                            <?= $pqr->due_date->format('d/m/Y') ?>
                                            <?php if ($pqr->isOverdue()): ?>
                                                <span class="badge bg-danger ms-1">Vencido</span>
                                            <?php endif; ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if ($pqr->resolved_at): ?>
                                        <p><strong>Fecha de Resolución:</strong> <?= $pqr->resolved_at->format('d/m/Y H:i') ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <hr>
                            <h6>Descripción:</h6>
                            <p><?= nl2br(h($pqr->description)) ?></p>
                            
                            <?php if (!empty($pqr->pqrs_responses)): ?>
                                <hr>
                                <h6>Respuestas:</h6>
                                <?php foreach ($pqr->pqrs_responses as $response): ?>
                                    <?php if (!$response->is_internal): ?>
                                        <div class="card mb-2">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <p class="mb-1"><?= nl2br(h($response->response_text)) ?></p>
                                                        <small class="text-muted">
                                                            Por: <?= h($response->user->first_name . ' ' . $response->user->last_name) ?> - 
                                                            <?= $response->created->format('d/m/Y H:i') ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php elseif ($ticketNumber): ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        No se encontró ningún PQRS con el número de ticket proporcionado.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>