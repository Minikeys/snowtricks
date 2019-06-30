<?php


namespace App\Controller\admin;


use App\Entity\Trick;
use App\Form\EditTrickType;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminTrickController extends AbstractController
{
    /**
     * @var TrickRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(TrickRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @param Trick $trick
     * @param Request $request
     *
     * @return RedirectResponse|Response
     * @Route("/admin/trick/edit/{id}", name="admin.trick.edit", methods="GET|POST")
     *
     */
    public function edit(Trick $trick, Request $request){

        $form = $this->createForm(EditTrickType::class, $trick);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash('success', 'Trick edit success');
            return $this->redirectToRoute('trick.show', array('slug' => $trick->getId(), 'id' => $trick->getId()));
        }

        return $this->render('admin/trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);

    }

    /**
     * @param Trick $trick
     * @param Request $request
     *
     * @return RedirectResponse
     * @Route("/admin/trick/delete/{id}", name="admin.trick.delete", methods="DELETE")
     */
    public function delete(Trick $trick, Request $request){

        if($this->isCsrfTokenValid('delete' . $trick->getId(), $request->get('_token'))){

            //$this->em->remove($trick);
            //$this->em->flush();
            $this->addFlash('success', 'Trick delete success');

        }else{

            $this->addFlash('error', 'Trick delete error');

        }

        return $this->redirectToRoute('home');

    }

}