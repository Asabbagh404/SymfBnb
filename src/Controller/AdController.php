<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AnnonceType;
use App\Repository\AdRepository;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
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

    public function create(Request $request){


        $ad = new ad;

        $form= $this->createForm(AnnonceType::class, $ad);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            foreach($ad->getImages()as $image){
                $image->setAd($ad);
                $manager->persist($image);
            }
            $manager->persist($ad);
            $manager->flush();



            return $this->redirectToRoute('ads_show',[
                'slug'=> $ad->getSlug(),
                'popup' => 'Felicitation ! vous venez de créer votre annonce !'
            ]);
        }
        dump($ad);
        return $this->render('ad/new.html.twig', [
            'controller_name' => 'AdController',
            'form'=>$form->createView()
        ]);


    }





    /**
     * @Route("/ads/{slug}/edit", name="ads_edit")
     *
     * @return Response
     */

    public function edit($slug, Request $request, AdRepository $repo, ObjectManager $manager){
        $ad = $repo->findOneBySlug($slug);
        $form= $this->createForm(AnnonceType::class, $ad);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            foreach($ad->getImages()as $image){
                $image->setAd($ad);
                $manager->persist($image);
            }
            $manager->persist($ad);
            $manager->flush();



            return $this->redirectToRoute('ads_show',[
                'slug'=> $ad->getSlug(),
                'popup' => 'Felicitation ! vous venez de modifier votre annonce !'
            ]);
        }

        return $this->render('ad/edit.html.twig',[
            'form'=>$form->createView(),
            'ad'=> $ad
        ]);

    }


    /**
     * @Route("/ads/{slug}", name="ads_show")
     *
     * @return Response
     */

    public function show($slug, AdRepository $repo, Request $request ){
        $ad = $repo->findOneBySlug($slug);
        return $this->render('ad/show.html.twig', [
            'controller_name' => 'AdController',
            'ad' => $ad,
            'popup' => $request->query->get("popup")
        ]);
    }





}
