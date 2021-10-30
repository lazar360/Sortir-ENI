<?php

namespace App\Entity;

use App\Repository\ParticipantPictureNameRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipantPictureNameRepository::class)
 */
class ParticipantPictureName
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity=Participant::class, inversedBy="participantPictureName", cascade={"persist", "remove"})
     */
    private $participant;

    /**
     * @ORM\OneToOne(targetEntity=Participant::class, mappedBy="picture", cascade={"persist", "remove"})
     */
    private $participant_name;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getParticipant(): ?Participant
    {
        return $this->participant;
    }

    public function setParticipant(?Participant $participant): self
    {
        $this->participant = $participant;

        return $this;
    }

    public function getParticipantName(): ?Participant
    {
        return $this->participant_name;
    }

    public function setParticipantName(?Participant $participant_name): self
    {
        // unset the owning side of the relation if necessary
        if ($participant_name === null && $this->participant_name !== null) {
            $this->participant_name->setPicture(null);
        }

        // set the owning side of the relation if necessary
        if ($participant_name !== null && $participant_name->getPicture() !== $this) {
            $participant_name->setPicture($this);
        }

        $this->participant_name = $participant_name;

        return $this;
    }
}
