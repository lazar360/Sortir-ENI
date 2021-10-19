<?php

namespace App\Entity;

use App\Repository\RejoindreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RejoindreRepository::class)
 */
class Rejoindre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInscription;

    /**
     * @ORM\ManyToOne(targetEntity=Participant::class, inversedBy="rejoindre_sorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sonParticipant;

    /**
     * @ORM\ManyToOne(targetEntity=Sortie::class, inversedBy="rejoindres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $saSortie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getSonParticipant(): ?Participant
    {
        return $this->sonParticipant;
    }

    public function setSonParticipant(?Participant $sonParticipant): self
    {
        $this->sonParticipant = $sonParticipant;

        return $this;
    }

    public function getSaSortie(): ?Sortie
    {
        return $this->saSortie;
    }

    public function setSaSortie(?Sortie $saSortie): self
    {
        $this->saSortie = $saSortie;

        return $this;
    }

}
