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
            'cliente_nombre' => 'First Name',
            'cliente_tel' => 'Last Name',
            'cliente_dir' => 'Gender',
            'cliente_email' => 'Phone',
            'cliente_desc' => 'Created at'
        ];

        return $ordering;
    }
}
?>
