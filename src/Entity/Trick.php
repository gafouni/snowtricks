<?php

namespace App\Entity;


use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TrickRepository;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=TrickRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *  fields={"trickName"},
 *  message="Cette figure existe deja !"
 * )
 */
class Trick
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
    private $trickName;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imgFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $videoFile;

    /**
     * @Gedmo\Slug(fields={"trickName"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    

    /**
     * @ORM\ManyToOne(targetEntity=TrickGroup::class, inversedBy="trick")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trickGroup;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="tricks", orphanRemoval=true)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="trick")
     */
    private $user;

    public function __construct()
    { 
        $this->message = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrickName(): ?string
    {
        return $this->trickName;
    }

    public function setTrickName(string $trickName): self
    {
        $this->trickName = $trickName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImgFile(): ?string
    {
        return $this->imgFile;
    }

    public function setImgFile(string $imgFile): self
    {
        $this->imgFile = $imgFile;

        return $this;
    }

    public function getVideoFile(): ?string
    {
        return $this->videoFile;
    }

    public function setVideoFile(string $videoFile): self
    {
        $this->videoFile = $videoFile;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    
    

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    

    

    public function getTrickGroup(): ?Trickgroup
    {
        return $this->trickGroup;
    }

    public function setTrickGroup(?Trickgroup $trickGroup): self
    {
        $this->trickGroup = $trickGroup;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessage(): Collection
    {
        return $this->message;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->message->contains($message)) {
            $this->message[] = $message;
            $message->setTrick($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->message->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getTrick() === $this) {
                $message->setTrick(null);
            }
        }

        return $this;
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
}
