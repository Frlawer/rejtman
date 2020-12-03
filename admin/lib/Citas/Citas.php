<?php
class Citas
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
            'cita_id' => 'ID',
            'area_id' => 'Area',
            'abogada_id' => 'Abogada',
            'cita_fecha' => 'Fecha'
        ];

        return $ordering;
    }
}
?>
