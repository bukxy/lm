<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FamiliarRepository")
 */
class Familiar
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="familiars")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $competence1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $competence2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $competence3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $competence1Desc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $competence2Desc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $competence3Desc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $talent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $talentDesc;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image", inversedBy="familiarBackground")
     */
    private $imageBackground;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image", inversedBy="familiarHead")
     */
    private $imageHead;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FamiliarCat", inversedBy="familiar")
     */
    private $familiarCat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getCompetence1(): ?string
    {
        return $this->competence1;
    }

    public function setCompetence1(?string $competence1): self
    {
        $this->competence1 = $competence1;

        return $this;
    }

    public function getCompetence2(): ?string
    {
        return $this->competence2;
    }

    public function setCompetence2(?string $competence2): self
    {
        $this->competence2 = $competence2;

        return $this;
    }

    public function getCompetence3(): ?string
    {
        return $this->competence3;
    }

    public function setCompetence3(?string $competence3): self
    {
        $this->competence3 = $competence3;

        return $this;
    }

    public function getCompetence1Desc(): ?string
    {
        return $this->competence1Desc;
    }

    public function setCompetence1Desc(?string $competence1Desc): self
    {
        $this->competence1Desc = $competence1Desc;

        return $this;
    }

    public function getCompetence2Desc(): ?string
    {
        return $this->competence2Desc;
    }

    public function setCompetence2Desc(string $competence2Desc): self
    {
        $this->competence2Desc = $competence2Desc;

        return $this;
    }

    public function getCompetence3Desc(): ?string
    {
        return $this->competence3Desc;
    }

    public function setCompetence3Desc(?string $competence3Desc): self
    {
        $this->competence3Desc = $competence3Desc;

        return $this;
    }

    public function getTalent(): ?string
    {
        return $this->talent;
    }

    public function setTalent(?string $talent): self
    {
        $this->talent = $talent;

        return $this;
    }

    public function getTalentDesc(): ?string
    {
        return $this->talentDesc;
    }

    public function setTalentDesc(?string $talentDesc): self
    {
        $this->talentDesc = $talentDesc;

        return $this;
    }

    public function getImageBackground(): ?Image
    {
        return $this->imageBackground;
    }

    public function setImageBackground(?Image $imageBackground): self
    {
        $this->imageBackground = $imageBackground;

        return $this;
    }

    public function getImageHead(): ?Image
    {
        return $this->imageHead;
    }

    public function setImageHead(?Image $imageHead): self
    {
        $this->imageHead = $imageHead;

        return $this;
    }

    public function getFamiliarCat(): ?FamiliarCat
    {
        return $this->familiarCat;
    }

    public function setFamiliarCat(?FamiliarCat $familiarCat): self
    {
        $this->familiarCat = $familiarCat;

        return $this;
    }
}
