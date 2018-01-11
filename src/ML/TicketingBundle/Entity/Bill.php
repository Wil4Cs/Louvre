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
 *     message = "Ce numéro de série est déjà utilisé"
 * )
 */
class Bill
{
    /**
     * @var bool
     *
     * @ORM\Column(name="ticket_type", type="boolean")
     * @Assert\Type(
     *     type = "bool",
     *     message = "{{value}} n'est pas de type {{type}}"
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
     * @Assert\Regex("/^[0-9]{13}$/")
     *
     */
    private $serialNumber;

    /**
     * @ORM\OneToMany(targetEntity="ML\TicketingBundle\Entity\Ticket", cascade={"persist"}, mappedBy="bill")
     * @Assert\Valid()
     */
    private $tickets;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="visit_day", type="date")
     * @Assert\Date(message = "Cette valeur n'est pas une date valide")
     */
    private $visitDay;

    /**
     * Bill constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime();
        $this->tickets = new ArrayCollection();
        $this->serialNumber = mt_rand(0, 9999999999999);
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
