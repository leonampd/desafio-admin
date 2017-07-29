<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Entity;


class Historic
{
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
     * @param \DateTime|null $time
     */
    public function __construct(string $action, string $oldValue, string $newValue, \DateTime $time = null)
    {
        $this->action = $action;
        $this->oldValue = $oldValue;
        $this->newValue = $newValue;
        $this->timestamp = $time;

        if (null === $time) {
            $this->timestamp = new \DateTime('now');
        }
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
        return $this->timestamp;
    }

    /**
     * @param \DateTime $timestamp
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }
}