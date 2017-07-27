<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Entity;

class Medicament
{
    /**
     * @var int id
     */
    protected $id;

    /**
     * @var string slug Valor não sequencial
     */
    protected $slug;

    /**
     * @var string ggrem
     */
    protected $ggrem;

    /**
     * @var string nome do remedio
     */
    protected $nome;

    /**
     * Medicament constructor.
     *
     * @param string $ggrem
     * @param string $nome
     */
    public function __construct(string $ggrem, string $nome)
    {
        $this->ggrem = $ggrem;
        $this->nome = $nome;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Medicament
     */
    public function setId(int $id): Medicament
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return Medicament
     */
    public function setSlug(string $slug): Medicament
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getGgrem(): string
    {
        return $this->ggrem;
    }

    /**
     * @param string $ggrem
     *
     * @return Medicament
     */
    public function setGgrem(string $ggrem): Medicament
    {
        $this->ggrem = $ggrem;

        return $this;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     *
     * @return Medicament
     */
    public function setNome(string $nome): Medicament
    {
        $this->nome = $nome;

        return $this;
    }

    public static function medicamentIsValid(Medicament $medicament)
    {
        if (!preg_match('/([0-9]+)/', $medicament->getGgrem()) ||
            !preg_match('/([a-zA-Z0-9\s])/', $medicament->getNome())
        ) {
            return false;
        }

        return true;
    }

    public static function createSlugForMedicament(Medicament $medicament)
    {
        $medicament->setSlug(sha1($medicament->getNome()));

        return $medicament;
    }
}
