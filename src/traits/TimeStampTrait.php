<?php

namespace App\traits;
use Doctrine\ORM\Mapping as ORM;

trait TimeStampTrait
{

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updatedAt;
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */

    public function onPrePersist(){
        $this->setCreatedAt(new \DateTime('NOW'));
        $this->setUpdatedAt(new \DateTime('NOW'));

    }

    /**
     * @ORM\PreUpdate()
     */
    public function onPreUpdate(){
        $this->setUpdatedAt(new \DateTime('NOW'));
    }

}