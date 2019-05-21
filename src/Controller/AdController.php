<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Repository\AdRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdController extends Controller
{
    /**
     * @Route("/ads", name="ad_index")
     */
    public function index(AdRepository $repo)
    {

        //$repo = $this->getDoctrine()->getRepository(Ad::class);dump($session);
        $ads = $repo-> findAll();
        return $this->render('ad/index.html.twig', [
            'controller_name' => 'AdController',
            'ads' => $ads
        ]);
    }


    /**
     * Permet de créer une annonce
     * @Route("/ads/new", name="ads_create")
     *
     * @return Response
     */

    public function create(){
        $ad = new ad;
        $form= $this->createForm(AdType::class, $ad);

         $formBuilded= $form->getForm();

        return $this->render('ad/new.html.twig', [
            'controller_name' => 'AdController',
            'form'=>$formBuilded->createView()
        ]);
    }


    /**
     * @Route("/ads/{slug}", name="ads_show")
     *
     * @return Response
     */

    public function show($slug, AdRepository $repo){
        $ad = $repo->findOneBySlug($slug);
        return $this->render('ad/show.html.twig', [
            'controller_name' => 'AdController',
            'ad' => $ad
        ]);
    }





}
