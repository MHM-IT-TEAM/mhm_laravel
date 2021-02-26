<?php


namespace App\Service;


class ConsultationService
{
    private $patId;
    private $typeConsult;
    private $invoices;
    private $vitalSigns;
    public function __construct($formData)
    {
        $this->patId= $formData->patId;
        $this->typeConsult=$formData->type_consult;
        $this->invoices=$formData->item;
        $this->vitalSigns= $formData->vitalSign;
    }
    public function store(){
        dd($this->vitalSigns);
    }
}
