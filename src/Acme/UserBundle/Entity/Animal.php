<?php

namespace AnimalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="Animal")
 * @ORM\Entity(repositoryClass="AnimalBundle\Doctrine\Repository\AnimalRepository")
 * @UniqueEntity(fields="Animal", message="Sorry, this Animal address is already in use.", groups={"addAddress"})
 */
class Animal
{
    const STATE_REGISTERED = 'registered';
    const STATE_UNREGISTERED = 'unregistered';
    const STATE_INVITED = 'invite';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**age / famille / race / nourriture

    /**
     * @var string
     *
     * @ORM\Column(name="Animal", type="string", length=255)
     */
    private $Animal;

    /**
     * @var string
     *
     * @ORM\Column(name="age", type="string", length=255,nullable=true)
     */
    private $age;
    /**
     * @var string
     *
     * @ORM\Column(name="famille", type="string", length=255,nullable=true)
     */
    private $famille;

    /**
     * @var string
     *
     * @ORM\Column(name="race", type="string", length=255,nullable=true)
     */
    private $race;

    /**
     * @var string
     *
     * @ORM\Column(name="nourriture", type="string", length=255,nullable=true)
     */
    private $nourriture;
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="Animals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="AnimalBundle\Entity\User", inversedBy="Animals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $animals;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=255)
     */
    private $state = self::STATE_UNREGISTERED;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set animal
     *
     * @param string $animal
     * @return Animal
     */
    public function setAnimal($animal)
    {
        $this->animal = $animal;

        return $this;
    }

    /**
     * Get animal
     *
     * @return string
     */
    public function getAnimal()
    {
        return $this->animal;
    }

    /**
     * Set age
     *
     * @param string $age
     * @return Animal
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get famille
     *
     * @return string
     */
    public function getFamille()
    {
        return $this->famille;
    }

    /**
     * Set Famille
     *
     * @param string $Famille
     * @return Famille
     */
    public function setFamille($Famille)
    {
        $this->Famille = $Famille;

        return $this;
    }

    /**
     * Get race
     *
     * @return string
     */
    public function getrace()
    {
        return $this->Race;
    }

    /**
     * Set race
     *
     * @param string $race
     * @return User
     */
    public function setRace($race)
    {
        $this->race = $race;

        return $this;
    }

    /**
     * Get nourriture
     *
     * @return string
     */
    public function getNourriture()
    {
        return $this->nourriture;
    }
    /**
     * Set nourriture
     *
     * @param string $nourriture
     * @return nourriture
     */
    public function setNourriture($nourriture)
    {
        $this->nourriture = $nourriture;

        return $this;
    }
    /**
     * Set user
     *
     * @param User $user
     * @return User
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return User
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Invite the contact
     *
     * @return bool
     */
    public function invite()
    {
        $this->setState(self::STATE_INVITED);
    }
}
