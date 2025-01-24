<?php

namespace App\Entity;

use App\Repository\ReactionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReactionRepository::class)]
class Reaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reactions')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'reactions')]
    private ?Picture $picture = null;

    #[ORM\Column]
    private ?bool $likeReaction = null;

    #[ORM\Column]
    private ?bool $dislikeReaction = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getPicture(): ?Picture
    {
        return $this->picture;
    }

    public function setPicture(?Picture $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function isLikeReaction(): ?bool
    {
        return $this->likeReaction;
    }

    public function setLikeReaction(bool $likeReaction): static
    {
        $this->likeReaction = $likeReaction;

        return $this;
    }

    public function isDislikeReaction(): ?bool
    {
        return $this->dislikeReaction;
    }

    public function setDislikeReaction(bool $dislikeReaction): static
    {
        $this->dislikeReaction = $dislikeReaction;

        return $this;
    }
}
