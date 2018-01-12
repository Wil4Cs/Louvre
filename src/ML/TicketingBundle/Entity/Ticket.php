<?php

namespace ML\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ticket
 *
 * @ORM\Table(name="ml_ticket")
 * @ORM\Entity(repositoryClass="ML\TicketingBundle\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     * @Assert\Length(
     *     min = 3,
     *     max = 255,
     *     minMessage = "Votre prénom doit comporter au moins {{ limit }} caractères",
     *     maxMessage = "Votre prénom ne doit pas comporter plus de {{ limit }} caractères"
     * )
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     * * @Assert\Length(
     *     min = 3,
     *     max = 255,
     *     minMessage = "Votre nom doit comporter au moins {{ limit }} caractères",
     *     maxMessage = "Votre nom ne doit pas comporter plus de {{ limit }} caractères"
     * )
     */
    private $lastName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date")
     * @Assert\Date(message = "Cette valeur n'est pas une date valide")
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     * @Assert\Country(message = "Cette valeur n'est pas un pays valide")
     */
    private $country;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="smallint")
     * @Assert\Type(
     *     type="integer",
     *     message="Cette valeur  {{ value }} n'est pas un {{ type }} valide."
     * )
     */
    private $price;

    /**
     * @ORM\Column(name="reduction", type="boolean")
     * @Assert\Type(
     *     type = "bool",
     *     message = "{{value}} n'est pas de type {{type}}"
     * )
     */
    private $reduction;

    /**
     * @ORM\ManyToOne(targetEntity="ML\TicketingBundle\Entity\Bill", inversedBy="tickets")
     *
     * @ORM\JoinColumn(nullable=false)
     */
    private $bill;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Ticket
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Ticket
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return Ticket
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Ticket
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Ticket
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReduction()
    {
        return $this->reduction;
    }

    /**
     * @param mixed $reduction
     */
    public function setReduction($reduction)
    {
        $this->reduction = $reduction;
    }

    /**
     * Set bill
     *
     * @param \ML\TicketingBundle\Entity\Bill $bill
     *
     * @return Ticket
     */
    public function setBill(Bill $bill)
    {
        $this->bill = $bill;

        return $this;
    }

    /**
     * Get bill
     *
     * @return \ML\TicketingBundle\Entity\Bill
     */
    public function getBill()
    {
        return $this->bill;
    }
}
