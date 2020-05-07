<?php

namespace App\Data;

use App\Entity\Filiere;
use App\Entity\SiteEntreposage;
use App\Entity\Technologie;

class SearchData
{

    /**
     * @var string
     */
    public $q = '';

    /**
     * @var SiteEntreposage[]
     */
    public $sites = [];

    /**
     * @var null|integer
     */
    public $maxQ;

    /**
     * @var null|integer
     */
    public $minQ;

    /**
     * @var Filiere[]
     */
    public $filieres = [];

    /**
     * @var Technologie[]
     */
    public $technos = [];

 }