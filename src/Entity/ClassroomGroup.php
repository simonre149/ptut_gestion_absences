<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClassroomGroupRepository")
 * @ApiResource
 */
class ClassroomGroup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\user", mappedBy="classroomGroup")
     */
    private $student;

    public function __construct()
    {
        $this->student = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|user[]
     */
    public function getStudent(): Collection
    {
        return $this->student;
    }

    public function addStudent(user $student): self
    {
        if (!$this->student->contains($student)) {
            $this->student[] = $student;
            $student->setClassroomGroup($this);
        }

        return $this;
    }

    public function removeStudent(user $student): self
    {
        if ($this->student->contains($student)) {
            $this->student->removeElement($student);
            // set the owning side to null (unless already changed)
            if ($student->getClassroomGroup() === $this) {
                $student->setClassroomGroup(null);
            }
        }

        return $this;
    }

    public function __toString() : string
    {
        return $this->name;
    }
}
