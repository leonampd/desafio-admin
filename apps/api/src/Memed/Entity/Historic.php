<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Entity;


class Historic
{
    const UPDATE = 'update';
    const CREATE = 'create';
    const DELETE = 'delete';

    /**
     * @var \Leonam\Memed\Entity\Medicament
     */
    protected $medicament;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $field;

    /**
     * @var string
     */
    protected $newValue;

    /**
     * @var string
     */
    protected $oldValue;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * Historic constructor.
     *
     * @param string $action
     * @param string $oldValue
     * @param string $newValue
     * @param \DateTime|null $date
     */
    public function __construct(
        Medicament $medicament,
        string $action,
        string $field,
        string $oldValue,
        string $newValue,
        \DateTime $date = null
    ) {
        $this->medicament = $medicament;
        $this->action = $action;
        $this->field = $field;
        $this->oldValue = $oldValue;
        $this->newValue = $newValue;
        $this->date = $date;

        if (null === $date) {
            $this->date = new \DateTime('now');
        }
    }

    /**
     * @return \Leonam\Memed\Entity\Medicament
     */
    public function getMedicament(): \Leonam\Memed\Entity\Medicament
    {
        return $this->medicament;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     *
     * @return Historic
     */
    public function setAction(string $action): Historic
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @param string $field
     */
    public function setField(string $field)
    {
        $this->field = $field;
    }

    /**
     * @return string
     */
    public function getNewValue(): string
    {
        return $this->newValue;
    }

    /**
     * @param string $newValue
     */
    public function setNewValue(string $newValue)
    {
        $this->newValue = $newValue;
    }

    /**
     * @return string
     */
    public function getOldValue(): string
    {
        return $this->oldValue;
    }

    /**
     * @param string $oldValue
     */
    public function setOldValue(string $oldValue)
    {
        $this->oldValue = $oldValue;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $timestamp
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }
}