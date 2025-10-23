<?php
/**
 * PQRS System Layout
 * @var \App\View\AppView $this
 */

$user = $this->getRequest()->getAttribute('identity');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        Sistema PQRS
        <?= $this->fetch('title') ? ' - ' . $this->fetch('title') : '' ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <?= $this->Html->css(['custom']) ?>
    
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <?= $this->Html->link('Sistema PQRS', ['controller' => 'Pqrs', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php if ($user): ?>
                        <li class="nav-item">
                            <?= $this->Html->link('<i class="fas fa-home"></i> Inicio', 
                                ['controller' => 'Pqrs', 'action' => 'index'], 
                                ['class' => 'nav-link', 'escape' => false]) ?>
                        </li>
                        
                        <?php if (in_array($user->role, ['admin', 'agent'])): ?>
                            <li class="nav-item">
                                <?= $this->Html->link('<i class="fas fa-tachometer-alt"></i> Dashboard', 
                                    ['controller' => 'Admin', 'action' => 'dashboard'], 
                                    ['class' => 'nav-link', 'escape' => false]) ?>
                            </li>
                            <li class="nav-item">
                                <?= $this->Html->link('<i class="fas fa-list"></i> Gestionar PQRS', 
                                    ['controller' => 'Admin', 'action' => 'pqrs'], 
                                    ['class' => 'nav-link', 'escape' => false]) ?>
                            </li>
                        <?php endif; ?>
                        
                        <?php if ($user->role === 'admin'): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-cog"></i> Administración
                                </a>
                                <ul class="dropdown-menu">
                                    <li><?= $this->Html->link('Usuarios', ['controller' => 'Admin', 'action' => 'users'], ['class' => 'dropdown-item']) ?></li>
                                    <li><?= $this->Html->link('Categorías', ['controller' => 'Admin', 'action' => 'categories'], ['class' => 'dropdown-item']) ?></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="nav-item">
                            <?= $this->Html->link('<i class="fas fa-plus"></i> Crear PQRS', 
                                ['controller' => 'Pqrs', 'action' => 'add'], 
                                ['class' => 'nav-link', 'escape' => false]) ?>
                        </li>
                        <li class="nav-item">
                            <?= $this->Html->link('<i class="fas fa-search"></i> Consultar PQRS', 
                                ['controller' => 'Pqrs', 'action' => 'track'], 
                                ['class' => 'nav-link', 'escape' => false]) ?>
                        </li>
                    <?php endif; ?>
                </ul>
                
                <ul class="navbar-nav">
                    <?php if ($user): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> <?= h($user->first_name) ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><span class="dropdown-item-text">Rol: <?= ucfirst($user->role) ?></span></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><?= $this->Html->link('Cerrar Sesión', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'dropdown-item']) ?></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <?= $this->Html->link('<i class="fas fa-sign-in-alt"></i> Iniciar Sesión', 
                                ['controller' => 'Users', 'action' => 'login'], 
                                ['class' => 'nav-link', 'escape' => false]) ?>
                        </li>
                        <li class="nav-item">
                            <?= $this->Html->link('<i class="fas fa-user-plus"></i> Registrarse', 
                                ['controller' => 'Users', 'action' => 'register'], 
                                ['class' => 'nav-link', 'escape' => false]) ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; <?= date('Y') ?> Sistema PQRS. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-end">
                    <p class="mb-0">Desarrollado con CakePHP</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->fetch('script') ?>
</body>
</html>
