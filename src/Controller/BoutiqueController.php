<?php

namespace App\Controller;

use App\Entity\Boutique;
use App\Entity\BoutiqueSearch;
use App\Form\BoutiqueSearchType;
use App\Repository\BoutiqueRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoutiqueController extends AbstractController
{
    /**
     * @Route("/boutique", name="boutique", methods={"GET", "POST"})
     */
    public function index(Request $request, PaginatorInterface $paginator, BoutiqueRepository $repository): Response
    {
        //formulaire de recherche
        $search=new BoutiqueSearch();
        $form=$this->createForm(BoutiqueSearchType::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $donnees=$repository->findByBoutiqueSearch($search);
        }else{
            $donnees=$repository->findAll();
        }
        $boutiques=$paginator->paginate( $donnees,
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('boutique/index.html.twig', [
            'boutiques' => $boutiques,
            'form' =>$form->createView()
        ]);
    }

    /**
     * @Route("/{id}/commerce", name="boutique_show", methods={"GET"})
     */
    public function show(Boutique $boutique): Response
    {
        return $this->render('boutique/show.html.twig', [
            'boutique' => $boutique,
        ]);
    }
}
