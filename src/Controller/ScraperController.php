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

    #public function GoogleSearch(String $keyWordUser){
        #$keyWordUser='twitter';
        #$ch=curl_init();//ouvre la connection
        #curl_setopt($ch,CURLOPT_URL,"https://www.google.com/search?q=".$keyWordUser);
        #curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1); //ici la valeur 1 vaut true
        #curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); //ici la valeur 1 vaut true
        #$response= curl_exec($ch);
        #curl_close($ch);//ferme la connection

        #echo $response;


    #}
}
