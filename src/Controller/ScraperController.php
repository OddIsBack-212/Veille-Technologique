<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ScraperController extends AbstractController
{
    /**
     * @Route("/scraper", name="scraper")
     */
    public function index()
    {

        return $this->render('scraper/index.html.twig', [
            'controller_name' => 'ScraperController','titre'=>'twitter'
        ]);
    }

   
}
