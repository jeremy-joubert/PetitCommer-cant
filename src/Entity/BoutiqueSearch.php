<?php


namespace App\Entity;


class BoutiqueSearch
{
    private $categorieBoutique;

    /**
     * @return mixed
     */
    public function getCategorieBoutique()
    {
        return $this->categorieBoutique;
    }

    /**
     * @param mixed $categorieBoutique
     */
    public function setCategorieBoutique($categorieBoutique): void
    {
        $this->categorieBoutique = $categorieBoutique;
    }


}