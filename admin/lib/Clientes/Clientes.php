<?php
class Clientes
{
    /**
     *
     */
    public function __construct()
    {
    }

    /**
     *
     */
    public function __destruct()
    {
    }
    
    /**
     * Set friendly columns\' names to order tables\' entries
     */
    public function setOrderingValues()
    {
        $ordering = [
            'cliente_id' => 'ID',
            'cliente_nombre' => 'Nombre',
            'cliente_tel' => 'Telefono',
            'cliente_dir' => 'Dirección',
            'cliente_email' => 'Email',
            'cliente_desc' => 'Descripción'
        ];

        return $ordering;
    }
}
?>
