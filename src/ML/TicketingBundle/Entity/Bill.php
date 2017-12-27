<?php

namespace ML\TicketingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Bill
 *
 * @ORM\Table(name="ml_bill")
 * @ORM\Entity(repositoryClass="ML\TicketingBundle\Repository\BillRepository")
 */
class Bill
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128)
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
     * @ORM\Column(name="ticket_number", type="smallint")
     */
    private $ticketNumber;

    /**
     * @var bool
     *
     * @ORM\Column(name="ticket_type", type="boolean")
     */
    private $daily;

    /**
     * @ORM\OneToMany(targetEntity="ML\TicketingBundle\Entity\Ticket", cascade={"persist"}, mappedBy="bill")
     */
    private $tickets;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="visit_day", type="datetime")
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
     * Set ticketNumber
     *
     * @param integer $ticketNumber
     *
     * @return Bill
     */
    public function setTicketNumber($ticketNumber)
    {
        $this->ticketNumber = $ticketNumber;

        return $this;
    }

    /**
     * Get ticketNumber
     *
     * @return integer
     */
    public function getTicketNumber()
    {
        return $this->ticketNumber;
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
     * @param \DateTime $visitDay
     *
     * @return Ticket
     */
    public function setVisitDay($visitDay)
    {
        $this->visitDay = $visitDay;

        return $this;
    }

    /**
     * Get visitDay
     *
     * @return \DateTime
     */
    public function getVisitDay()
    {
        return $this->visitDay;
    }
}
