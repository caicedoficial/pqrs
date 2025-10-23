<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class SeedInitialData extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function up(): void
    {
        // Insert categories
        $this->execute("INSERT INTO categories (name, description, is_active, created, modified) VALUES
            ('Servicios', 'Problemas relacionados con servicios', 1, NOW(), NOW()),
            ('Facturación', 'Consultas sobre facturación y pagos', 1, NOW(), NOW()),
            ('Atención al Cliente', 'Quejas sobre atención al cliente', 1, NOW(), NOW()),
            ('Productos', 'Sugerencias y reclamos sobre productos', 1, NOW(), NOW()),
            ('Técnico', 'Problemas técnicos', 1, NOW(), NOW())");
        
        // Insert admin user
        $this->execute("INSERT INTO users (email, password, first_name, last_name, phone, role, is_active, created, modified) VALUES
            ('admin@pqrs.com', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'Sistema', '1234567890', 'admin', 1, NOW(), NOW()),
            ('agente@pqrs.com', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Agente', 'Soporte', '1234567891', 'agent', 1, NOW(), NOW()),
            ('usuario@pqrs.com', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Usuario', 'Prueba', '1234567892', 'requester', 1, NOW(), NOW())");
    }

    public function down(): void
    {
        $this->execute('DELETE FROM categories');
        $this->execute('DELETE FROM users');
    }
}
