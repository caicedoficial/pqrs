<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Pqr> $pqrs
 * @var \App\Model\Entity\User|null $user
 */
$this->assign('title', 'Mis PQRS');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-list"></i> Mis PQRS</h2>
    <?= $this->Html->link('Crear Nueva PQRS', ['action' => 'add'], [
        'class' => 'btn btn-primary'
    ]) ?>
</div>

<?php if ($pqrs->count() > 0): ?>
    <div class="row">
        <?php foreach ($pqrs as $pqr): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card pqrs-card priority-<?= h($pqr->priority) ?> <?= $pqr->isOverdue() ? 'overdue' : '' ?>">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <small class="text-muted"><?= h($pqr->ticket_number) ?></small>
                        <span class="badge <?= $pqr->getStatusBadgeClass() ?>">
                            <?= ucfirst(h($pqr->status)) ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title"><?= h($pqr->subject) ?></h6>
                        <p class="card-text">
                            <small class="text-muted">
                                <?= $pqr->getTypeDisplayName() ?> - <?= h($pqr->category->name) ?>
                            </small>
                        </p>
                        <p class="card-text">
                            <?= $this->Text->truncate(h($pqr->description), 100) ?>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <?= $pqr->created->format('d/m/Y') ?>
                                <?php if ($pqr->isOverdue()): ?>
                                    <span class="badge bg-danger ms-1">Vencido</span>
                                <?php endif; ?>
                            </small>
                            <span class="badge <?= $pqr->getPriorityBadgeClass() ?>">
                                <?= ucfirst(h($pqr->priority)) ?>
                            </span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <?= $this->Html->link('Ver Detalles', ['action' => 'view', $pqr->id], [
                            'class' => 'btn btn-sm btn-outline-primary'
                        ]) ?>
                        <?php if ($user && in_array($user->role, ['admin', 'agent'])): ?>
                            <?= $this->Html->link('Editar', ['action' => 'edit', $pqr->id], [
                                'class' => 'btn btn-sm btn-outline-secondary'
                            ]) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <div class="d-flex justify-content-center">
        <?= $this->Paginator->numbers([
            'class' => 'pagination',
            'prev' => 'Anterior',
            'next' => 'Siguiente'
        ]) ?>
    </div>
<?php else: ?>
    <div class="text-center py-5">
        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
        <h4>No hay PQRS registrados</h4>
        <p class="text-muted">Comience creando su primera PQRS</p>
        <?= $this->Html->link('Crear PQRS', ['action' => 'add'], [
            'class' => 'btn btn-primary'
        ]) ?>
    </div>
<?php endif; ?>