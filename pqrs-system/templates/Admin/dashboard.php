<?php
/**
 * @var \App\View\AppView $this
 * @var array $stats
 * @var iterable<\App\Model\Entity\Pqr> $recentPqrs
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Dashboard');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
    <div>
        <span class="badge bg-primary"><?= ucfirst(h($user->role)) ?></span>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= number_format($stats['total_pqrs']) ?></h4>
                        <p class="mb-0">Total PQRS</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-list-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= number_format($stats['pending_pqrs']) ?></h4>
                        <p class="mb-0">Pendientes</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= number_format($stats['in_progress_pqrs']) ?></h4>
                        <p class="mb-0">En Proceso</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-spinner fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= number_format($stats['resolved_pqrs']) ?></h4>
                        <p class="mb-0">Resueltos</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($stats['overdue_pqrs'] > 0): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i>
        <strong>Atención:</strong> Hay <?= number_format($stats['overdue_pqrs']) ?> PQRS vencidos que requieren atención inmediata.
    </div>
<?php endif; ?>

<!-- Recent PQRS -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">PQRS Recientes</h5>
        <?= $this->Html->link('Ver Todos', ['action' => 'pqrs'], [
            'class' => 'btn btn-sm btn-outline-primary'
        ]) ?>
    </div>
    <div class="card-body">
        <?php if ($recentPqrs->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Ticket</th>
                            <th>Tipo</th>
                            <th>Asunto</th>
                            <th>Estado</th>
                            <th>Prioridad</th>
                            <th>Creado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentPqrs as $pqr): ?>
                            <tr class="<?= $pqr->isOverdue() ? 'table-danger' : '' ?>">
                                <td>
                                    <code><?= h($pqr->ticket_number) ?></code>
                                    <?php if ($pqr->isOverdue()): ?>
                                        <i class="fas fa-exclamation-triangle text-danger ms-1" title="Vencido"></i>
                                    <?php endif; ?>
                                </td>
                                <td><?= $pqr->getTypeDisplayName() ?></td>
                                <td><?= $this->Text->truncate(h($pqr->subject), 40) ?></td>
                                <td>
                                    <span class="badge <?= $pqr->getStatusBadgeClass() ?>">
                                        <?= ucfirst(h($pqr->status)) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?= $pqr->getPriorityBadgeClass() ?>">
                                        <?= ucfirst(h($pqr->priority)) ?>
                                    </span>
                                </td>
                                <td><?= $pqr->created->format('d/m/Y') ?></td>
                                <td>
                                    <?= $this->Html->link('<i class="fas fa-eye"></i>', 
                                        ['controller' => 'Pqrs', 'action' => 'view', $pqr->id], 
                                        ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false, 'title' => 'Ver']) ?>
                                    
                                    <?php if (!$pqr->assigned_agent_id && in_array($user->role, ['admin', 'agent'])): ?>
                                        <?= $this->Html->link('<i class="fas fa-user-plus"></i>', 
                                            ['controller' => 'Pqrs', 'action' => 'assign', $pqr->id], 
                                            ['class' => 'btn btn-sm btn-outline-success', 'escape' => false, 'title' => 'Asignar']) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-4">
                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                <p class="text-muted">No hay PQRS recientes</p>
            </div>
        <?php endif; ?>
    </div>
</div>