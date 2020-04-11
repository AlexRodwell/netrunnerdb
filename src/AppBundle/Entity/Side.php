<?php

namespace AppBundle\Entity;

use AppBundle\Behavior\Entity\CodeNameInterface;
use AppBundle\Behavior\Entity\NormalizableInterface;
use AppBundle\Behavior\Entity\TimestampableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Side
 */
class Side implements NormalizableInterface, TimestampableInterface, CodeNameInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Collection
     */
    private $cards;

    /**
     * @var Collection
     */
    private $factions;

    /**
     * @var Collection
     */
    private $decks;

    /**
     * @var Collection
     */
    private $decklists;

    /**
     * @var string
     */
    private $code;

    /**
     * @var \DateTime
     */
    private $dateCreation;

    /**
     * @var \DateTime
     */
    private $dateUpdate;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cards = new ArrayCollection();
        $this->factions = new ArrayCollection();
        $this->decks = new ArrayCollection();
        $this->decklists = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name ?: '(unknown)';
    }

    public function normalize()
    {
        return [
                'code' => $this->code,
                'name' => $this->name
        ];
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Side
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add cards
     * @param Card $cards
     * @return Side
     */
    public function addCard(Card $cards)
    {
        $this->cards[] = $cards;

        return $this;
    }

    /**
     * Remove cards
     * @param Card $cards
     */
    public function removeCard(Card $cards)
    {
        $this->cards->removeElement($cards);
    }

    /**
     * @return Collection
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * Add decks
     * @param Deck $decks
     * @return Side
     */
    public function addDeck(Deck $decks)
    {
        $this->decks[] = $decks;

        return $this;
    }

    /**
     * Remove decks
     * @param Deck $decks
     */
    public function removeDeck(Deck $decks)
    {
        $this->decks->removeElement($decks);
    }

    /**
     * @return Collection
     */
    public function getDecks()
    {
        return $this->decks;
    }

    /**
     * @return Collection
     */
    public function getDecklists()
    {
        return $this->decklists;
    }

    /**
     * @return Collection
     */
    public function getFactions()
    {
        return $this->factions;
    }

    /**
     * Add factions
     * @param Faction $factions
     * @return Side
     */
    public function addFaction(Faction $factions)
    {
        $this->factions[] = $factions;

        return $this;
    }

    /**
     * Remove factions
     * @param Faction $factions
     */
    public function removeFaction(Faction $factions)
    {
        $this->factions->removeElement($factions);
    }

    /**
     * Add decklists
     * @param Decklist $decklists
     * @return Side
     */
    public function addDecklist(Decklist $decklists)
    {
        $this->decklists[] = $decklists;

        return $this;
    }

    /**
     * Remove decklists
     * @param Decklist $decklists
     */
    public function removeDecklist(Decklist $decklists)
    {
        $this->decklists->removeElement($decklists);
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Side
     */
    public function setCode(string $code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param \DateTime $dateCreation
     * @return Side
     */
    public function setDateCreation(\DateTime $dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    /**
     * @param \DateTime $dateUpdate
     * @return Side
     */
    public function setDateUpdate(\DateTime $dateUpdate)
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }
}
