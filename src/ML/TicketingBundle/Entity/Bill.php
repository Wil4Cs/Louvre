<?php

namespace ML\TicketingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Bill
 *
 * @ORM\Table(name="ml_bill")
 * @ORM\Entity(repositoryClass="ML\TicketingBundle\Repository\BillRepository")
 * @UniqueEntity(
 *     fields = {"serialNumber"},
 *     message = "Une erreur est survenue lors de la validation de votre commande. Nous vous prions de nous en excuser!"
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Bill
{
    /**
     * @var bool
     *
     * @ORM\Column(name="order_type", type="boolean")
     * @Assert\Type(
     *     type = "bool",
     *     message = "{{ value }} n'est pas de type {{ type }}"
     * )
     */
    private $daily;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\Date(message = "Cette valeur n'est pas une date valide")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128)
     * @Assert\NotNull(message = "Ce champ ne peut être nul")
     * @Assert\Email(message = "Cette valeur n'est pas une adresse e-mail valide",
     *     checkMX = true,
     *     checkHost = true
     * )
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="serial_number", type="bigint", unique=true)
     */
    private $serialNumber;

    /**
     * @ORM\OneToMany(targetEntity="ML\TicketingBundle\Entity\Ticket", cascade={"persist"}, mappedBy="bill")
     * @Assert\Valid()
     * @Assert\Count(
     *     min = 1,
     *     max = 10,
     *     minMessage = "Une commande doit comporter au minimum {{ limit }} billet",
     *     maxMessage = "Une commande ne peut comporter que {{ limit }} billets maximum"
     * )
     */
    private $tickets;

    /**
     * var string
     *
     * @ORM\Column(name="stripe_token", type="string", length=128)
     */
    private $stripeToken;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="visit_day", type="date")
     * @Assert\NotNull(message = "Ce champ ne peut être nul")
     * @Assert\Date(message = "Cette valeur n'est pas une date valide")
     * @Assert\GreaterThanOrEqual("today", message = "Cette date doit être supérieure ou égale au {{ compared_value }}")
     */
    private $visitDay;

    /**
     * Bill constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime();
        $this->tickets = new ArrayCollection();
    }

    /**
     * Validate if someone try to order a daily ticket after 2pm (14:00:00)
     *
     * @Assert\IsTrue(message="Impossible de commander un billet Journée pour aujourd'hui après 14h")
     */
    public function isDate()
    {
        $todayDate = $this->date->format('d m Y');
        $todayHour = $this->date->format('H');
        $visitDate = $this->visitDay->format('d m Y');

        if ($todayDate === $visitDate && $todayHour >= 14 && $this->daily === true) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Compute the total price of all tickets link to the bill
     */
    public function getTotalPrice()
    {
        $price = 0;
        $tickets = $this->getTickets();
        foreach ($tickets as $ticket) {
            $price += $ticket->getPrice();
        }

        return $price;
    }

    /**
     * Create a serial number before flush
     *
     * @ORM\PrePersist
     */
    public function createSerialNumber()
    {
        $this->setSerialNumber(uniqid('MDL_'));
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Bill
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getDaily()
    {
        return $this->daily;
    }

    /**
     * @param mixed $daily
     */
    public function setDaily($daily)
    {
        $this->daily = $daily;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Bill
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

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
     * Set serialNumber
     *
     * @param integer $serialNumber
     *
     * @return Bill
     */
    public function setSerialNumber($serialNumber)
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    /**
     * Get serialNumber
     *
     * @return int
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * Add ticket
     *
     * @param \ML\TicketingBundle\Entity\Ticket $ticket
     *
     * @return Bill
     */
    public function addTicket(Ticket $ticket)
    {
        $this->tickets[] = $ticket;

        $ticket->setBill($this);

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \ML\TicketingBundle\Entity\Ticket $ticket
     */
    public function removeTicket(Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Get stripe token
     *
     * @return string
     */
    public function getStripeToken()
    {
        return $this->stripeToken;
    }

    /**
     * Set stripe token
     *
     * @param string $stripeToken
     *
     * @return Bill
     */
    public function setStripeToken($stripeToken)
    {
        $this->stripeToken = $stripeToken;

        return $this;
    }

    /**
     * Set visitDay
     *
     * @param \Datetime $visitDay
     *
     * @return Bill
     */
    public function setVisitDay($visitDay)
    {
        $this->visitDay = $visitDay;

        return $this;
    }

    /**
     * Get visitDay
     *
     * @return \Datetime
     */
    public function getVisitDay()
    {
        return $this->visitDay;
    }
}
