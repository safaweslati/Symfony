<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use App\traits\TimeStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;




#[ORM\Entity(repositoryClass: PersonneRepository::class)]
/**
 * @ORM\HasLifecycleCallbacks()
 */
class Personne
{
    use TimeStampTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 50)]
    private $name;

    #[ORM\Column(type: 'smallint')]
    private $age;

    #[ORM\Column(type: 'string', length: 50)]
    private $job;

    #[ORM\OneToOne(inversedBy: 'personne', targetEntity: Profile::class, cascade: ['persist', 'remove'])]
    private $profile;

    #[ORM\ManyToMany(targetEntity: Hobbie::class)]
    private $hobbies;

    #[ORM\ManyToOne(targetEntity: Job::class, inversedBy: 'personnes')]
    private $travail;


    public function __construct()
    {
        $this->hobbies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(string $job): self
    {
        $this->job = $job;

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * @return Collection<int, Hobbie>
     */
    public function getHobbies(): Collection
    {
        return $this->hobbies;
    }

    public function addHobby(Hobbie $hobby): self
    {
        if (!$this->hobbies->contains($hobby)) {
            $this->hobbies[] = $hobby;
        }

        return $this;
    }

    public function removeHobby(Hobbie $hobby): self
    {
        $this->hobbies->removeElement($hobby);

        return $this;
    }

    public function getTravail(): ?Job
    {
        return $this->travail;
    }

    public function setTravail(?Job $travail): self
    {
        $this->travail = $travail;

        return $this;
    }



}
