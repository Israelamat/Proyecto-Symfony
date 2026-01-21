<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column]
    private \DateTimeImmutable $eventDate;

    #[ORM\ManyToMany(targetEntity: Game::class, inversedBy: 'events')]
    #[ORM\JoinTable(name: 'event_games')]
    private Collection $games;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $organizer = null;

    public function __construct()
    {
        $this->games = new ArrayCollection();
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }   

    public function getEventDate(): \DateTimeImmutable
    {
        return $this->eventDate;
    }

    public function setEventDate(\DateTimeImmutable $eventDate): self
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        $this->games->removeElement($game);

        return $this;
    }

    public function getOrganizer(): ?User
    {
        return $this->organizer;
    }

    public function setOrganizer(?User $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }
}
