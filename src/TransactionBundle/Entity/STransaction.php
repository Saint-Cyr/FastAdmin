<?php

namespace TransactionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * STransaction
 *
 * @ORM\Table(name="s_transaction")
 * @ORM\Entity(repositoryClass="TransactionBundle\Repository\STransactionRepository")
 */
class STransaction
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
     * @ORM\ManyToOne(targetEntity="KmBundle\Entity\Branch", inversedBy="stransactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $branch;
    
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var float
     *
     * @ORM\Column(name="totalAmount", type="float")
     */
    private $totalAmount;
    
    /**
     * @var float
     *
     * @ORM\Column(name="profit", type="float", nullable=true)
     */
    private $profit;
    
    /**
     * @ORM\OneToMany(targetEntity="Sale", mappedBy="stransaction", cascade={"remove", "all"})
     */
    private $sales;
    
    private $oneTime;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function isOneTime()
    {
        return $this;
    }
    
    public function __toString() {
        return 'STransaction object: '.$this->getId();
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return STransaction
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
     * Set totalAmount
     *
     * @param float $totalAmount
     *
     * @return STransaction
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * Get totalAmount
     *
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setCreatedAt(new \DateTime("now"));
        $this->sales = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add sale
     *
     * @param \TransactionBundle\Entity\Sale $sale
     *
     * @return STransaction
     */
    public function addSale(\TransactionBundle\Entity\Sale $sale)
    {
        $this->sales[] = $sale;

        return $this;
    }

    /**
     * Remove sale
     *
     * @param \TransactionBundle\Entity\Sale $sale
     */
    public function removeSale(\TransactionBundle\Entity\Sale $sale)
    {
        $this->sales->removeElement($sale);
    }

    /**
     * Get sales
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSales()
    {
        return $this->sales;
    }

    /**
     * Set profit
     *
     * @param float $profit
     * @deprecated since version 1.0_alpha
     * @return STransaction
     */
    public function setProfit()
    {
        //Cumumlate the profites from each sale
        $total = 0;
        
        foreach ($this->getSales() as $sale){
            //Because setProfit() method of $sale is 
            //a custom one, then call it
            $sale->setProfit();
            $total = $total + $sale->getProfit();
        }
        
        $this->profit = $total;
         
    }

    /**
     * Get profit
     *
     * @return float
     */
    public function getProfit()
    {
        $profit = null;
        
        foreach ($this->getSales() as $sale){
            $profit = $profit + $sale->getProfit();
        }
        
        return $profit;
    }

    /**
     * Set branch
     *
     * @param \KmBundle\Entity\Branch $branch
     *
     * @return STransaction
     */
    public function setBranch(\KmBundle\Entity\Branch $branch = null)
    {
        $this->branch = $branch;

        return $this;
    }

    /**
     * Get branch
     *
     * @return \KmBundle\Entity\Branch
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return STransaction
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set oneTime
     *
     * @param boolean $oneTime
     *
     * @return STransaction
     */
    public function setOneTime($oneTime)
    {
        $this->oneTime = $oneTime;

        return $this;
    }

    /**
     * Get oneTime
     *
     * @return boolean
     */
    public function getOneTime()
    {
        return $this->oneTime;
    }
}
