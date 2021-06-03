<?php

namespace App\Controller;

use App\Entity\Boutique;
use App\Entity\CategorieBoutique;
use App\Entity\Commercant;
use App\Entity\Horaire;
use App\Entity\Image;
use App\Entity\Temoinage;
use App\Form\BoutiqueType;
use App\Form\CategorieBoutiqueType;
use App\Form\CommercantType;
use App\Form\HoraireType;
use App\Form\ImageType;
use App\Form\NewCommercantType;
use App\Form\SearchBarType;
use App\Repository\BoutiqueRepository;
use App\Repository\CommercantRepository;
use App\Repository\TemoinageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin84f681f48e51d", name="admin")
     * @isGranted("ROLE_ADMIN")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin84f681f48e51d/boutique", name="admin_boutique")
     * @isGranted("ROLE_ADMIN")
     */
    public function boutique(Request $request, PaginatorInterface $paginator, BoutiqueRepository $repository): Response
    {
        $form = $this->createForm(SearchBarType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $donnees = $repository->findByName($form->get('nom')->getData());
        }else{
            $donnees = $repository->findAll();
        }
        $boutiques = $paginator->paginate($donnees,
            $request->query->getInt('page', 1),
            25
        );
        return $this->render('admin/boutique.html.twig', [
            'form' => $form->createView(),
            'boutiques' => $boutiques
        ]);
    }

    /**
     * @Route("/admin84f681f48e51d/{id}/editboutique", name="admin_boutique_edit", methods={"GET","POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Boutique $boutique): Response
    {
        $form = $this->createForm(BoutiqueType::class, $boutique);
        $form->handleRequest($request);

        $formImage = $this->createForm(ImageType::class);
        $formImage->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            foreach ($boutique->getCategorieBoutiques() as $categorieBoutique){
                $categorieBoutique->removeBoutique($boutique);
                $entityManager->persist($categorieBoutique);
            }
            $entityManager->flush();
            $categorieBoutiques = $form->get('categorieBoutiques')->getData();
            foreach ($categorieBoutiques as $categorieBoutique){
                $categorieBoutique->addBoutique($boutique);
                $entityManager->persist($categorieBoutique);
            }
            $entityManager->flush();
            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('admin_boutique');
        }

        if ($formImage->isSubmitted() && $formImage->isValid()) {
            //stockage des images
            $entityManager = $this->getDoctrine()->getManager();
            $images = $formImage->get('picture')->getData();
            foreach ($images as $image) {
                $nomImage = md5(uniqid()) . '.png';
                $image->move(
                    $this->getParameter('images_directory'),
                    $nomImage
                );
                $imageEntity = new Image();
                $imageEntity->setLien($nomImage);
                $imageEntity->setBoutique($boutique);
                $entityManager->persist($imageEntity);
            }
            $entityManager->flush();

            return $this->redirectToRoute('admin_boutique_edit', ['id' => $boutique->getId()]);
        }

        return $this->render('admin/edit_boutique.html.twig', [
            'form' => $form->createView(),
            'formImage' => $formImage->createView(),
            'boutique' => $boutique
        ]);
    }

    /**
     * @Route("/admin84f681f48e51d/{id}/deleteImage", name="admin_image_delete" , methods={"GET"})
     * @isGranted("ROLE_ADMIN")
     */
    public function deleteImage(Image $image): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($image);
        $entityManager->flush();

        return $this->redirectToRoute('admin_boutique_edit', ['id' => $image->getBoutique()->getId()]);
    }

    /**
     * @Route("/admin84f681f48e51d/{id}/deleteImageCommercant", name="admin_image_commercant_delete" , methods={"GET"})
     * @isGranted("ROLE_ADMIN")
     */
    public function deleteImageCommercant(Image $image): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($image);
        $entityManager->flush();

        return $this->redirectToRoute('admin_commercant_edit', ['id' => $image->getCommercant()->getId()]);
    }

    /**
     * @Route("/admin84f681f48e51d/{id}/deleteHoraire", name="admin_image_horaire" , methods={"GET"})
     * @isGranted("ROLE_ADMIN")
     */
    public function deleteHoraire(Horaire $horaire): Response
    {
        $boutique = $horaire->getBoutique()[0];
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($horaire);
        $entityManager->flush();

        return $this->redirectToRoute('admin_boutique_edit', ['id' => $boutique->getId()]);
    }

    /**
     * @Route("/admin84f681f48e51d/{id}/newHoraire", name="admin_horaire_new", methods={"GET","POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function newHoraire(Request $request, Boutique $boutique): Response
    {
        $horaire = new Horaire();
        $horaire->addBoutique($boutique);
        $form = $this->createForm(HoraireType::class, $horaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($horaire);
            $entityManager->flush();

            return $this->redirectToRoute('admin_boutique_edit', ['id' => $boutique->getId()]);
        }

        return $this->render('admin/new.html.twig', [
            'titre' => 'Ajouter une horaire',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin84f681f48e51d/{id}/newCategorie", name="admin_categorie_new", methods={"GET","POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function newCategorie(Request $request, Boutique $boutique): Response
    {
        $categorieBoutique = new CategorieBoutique();
        $categorieBoutique->addBoutique($boutique);
        $form = $this->createForm(CategorieBoutiqueType::class, $categorieBoutique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorieBoutique);
            $entityManager->flush();

            return $this->redirectToRoute('admin_boutique_edit', ['id' => $boutique->getId()]);
        }

        return $this->render('admin/new.html.twig', [
            'titre' => 'Ajouter une horaire',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin84f681f48e51d/newBoutique", name="admin_boutique_new", methods={"GET","POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function newBoutique(Request $request): Response
    {
        $boutique = new Boutique();
        $form = $this->createForm(BoutiqueType::class, $boutique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $categorieBoutiques = $form->get('categorieBoutiques')->getData();
            foreach ($categorieBoutiques as $categorieBoutique){
                $categorieBoutique->addBoutique($boutique);
                $entityManager->persist($categorieBoutique);
            }
            $entityManager->persist($boutique);
            $entityManager->flush();

            return $this->redirectToRoute('admin_boutique_edit', ['id' => $boutique->getId()]);
        }

        return $this->render('admin/new.html.twig', [
            'titre' => 'Créer une nouvelle boutique',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin84f681f48e51d/temoinage", name="admin_temoinage")
     * @isGranted("ROLE_ADMIN")
     */
    public function temoinage(Request $request, PaginatorInterface $paginator, TemoinageRepository $repository): Response
    {
        $form = $this->createForm(SearchBarType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $donnees = $repository->findByName($form->get('nom')->getData());
        }else{
            $donnees = $repository->findAll();
        }
        $temoinage = $paginator->paginate($donnees,
            $request->query->getInt('page', 1),
            25
        );
        return $this->render('admin/temoinage.html.twig', [
            'form' => $form->createView(),
            'temoinages' => $temoinage
        ]);
    }

    /**
     * @Route("/admin84f681f48e51d/commercant", name="admin_commercant")
     * @isGranted("ROLE_ADMIN")
     */
    public function commercant(Request $request, PaginatorInterface $paginator, CommercantRepository $repository): Response
    {
        $form = $this->createForm(SearchBarType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $donnees = $repository->findByName($form->get('nom')->getData());
        }else{
            $donnees = $repository->findAll();
        }
        $commercant = $paginator->paginate($donnees,
            $request->query->getInt('page', 1),
            25
        );
        return $this->render('admin/commercant.html.twig', [
            'form' => $form->createView(),
            'commercants' => $commercant
        ]);
    }

    /**
     * @Route("/admin84f681f48e51d/newCommercant", name="admin_commercant_new", methods={"GET","POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function newCommercant(Request $request): Response
    {
        $commercant = new Commercant();
        $form = $this->createForm(NewCommercantType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //stockage des images
            $images = $form->get('images')->getData();
            $commercant->setNom($form->get('nom')->getData());
            $commercant->setPrenom($form->get('prenom')->getData());
            $commercant->setBoutique($form->get('boutique')->getData());
            foreach ($images as $image) {
                $nomImage = md5(uniqid()) . '.png';
                $image->move(
                    $this->getParameter('images_directory'),
                    $nomImage
                );
                $imageEntity = new Image();
                $imageEntity->setLien($nomImage);
                $imageEntity->setCommercant($commercant);
                $entityManager->persist($imageEntity);
            }
            $entityManager->persist($commercant);
            $entityManager->flush();

            return $this->redirectToRoute('admin_commercant_edit', ['id' => $commercant->getId()]);
        }


        return $this->render('admin/new.html.twig', [
            'titre' => 'Créer un nouveau commerçant',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin84f681f48e51d/{id}/editCommercant", name="admin_commercant_edit", methods={"GET","POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function editCommercant(Request $request, Commercant $commercant): Response
    {
        $form = $this->createForm(CommercantType::class, $commercant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commercant);
            $entityManager->flush();

            return $this->redirectToRoute('admin_boutique_edit', ['id' => $commercant->getBoutique()->getId()]);
        }

        $formImage = $this->createForm(ImageType::class);
        $formImage->handleRequest($request);

        if ($formImage->isSubmitted() && $formImage->isValid()) {
            //stockage des images
            $entityManager = $this->getDoctrine()->getManager();
            $images = $formImage->get('picture')->getData();
            foreach ($images as $image) {
                $nomImage = md5(uniqid()) . '.png';
                $image->move(
                    $this->getParameter('images_directory'),
                    $nomImage
                );
                $imageEntity = new Image();
                $imageEntity->setLien($nomImage);
                $imageEntity->setCommercant($commercant);
                $entityManager->persist($imageEntity);
            }
            $entityManager->flush();

            return $this->redirectToRoute('admin_commercant_edit', ['id' => $commercant->getId()]);
        }

        return $this->render('admin/edit_commercant.html.twig', [
            'commercant' => $commercant,
            'formCommercant' => $form->createView(),
            'formImage' => $formImage->createView()
        ]);
    }

    /**
     * @Route("/admin84f681f48e51d/{id}/deleteCommercant", name="admin_commercant_delete" , methods={"GET"})
     * @isGranted("ROLE_ADMIN")
     */
    public function deleteCommercant(Commercant $commercant): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        foreach ($commercant->getImages() as $image) {
            $entityManager->remove($image);
        }
        $entityManager->remove($commercant);
        $entityManager->flush();

        return $this->redirectToRoute('admin_boutique_edit', ['id' => $commercant->getBoutique()->getId()]);
    }

    /**
     * @Route("/admin84f681f48e51d/{id}/deleteBoutique", name="admin_boutique_delete" , methods={"GET"})
     * @isGranted("ROLE_ADMIN")
     */
    public function deleteBoutique(Boutique $boutique): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        foreach ($boutique->getImages() as $image) {
            $entityManager->remove($image);
        }
        foreach ($boutique->getCommercants() as $commercant) {
            $entityManager->remove($commercant);
        }
        foreach ($boutique->getHoraires() as $horaire) {
            $entityManager->remove($horaire);
        }
        $entityManager->remove($boutique);
        $entityManager->flush();

        return $this->redirectToRoute('admin_boutique');
    }

    /**
     * @Route("/admin84f681f48e51d/{id}/activerTemoinage", name="admin_activer_temoinage", methods={"GET","POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function activerTemoinage(Temoinage $temoinage): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $temoinage->setActif(true);
        $entityManager->persist($temoinage);
        $entityManager->flush();

        return $this->redirectToRoute('admin_temoinage');

    }

    /**
     * @Route("/admin84f681f48e51d/{id}/desactiverTemoinage", name="admin_desactiver_temoinage", methods={"GET","POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function desactiverTemoinage(Temoinage $temoinage): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $temoinage->setActif(false);
        $entityManager->persist($temoinage);
        $entityManager->flush();

        return $this->redirectToRoute('admin_temoinage');

    }
}
