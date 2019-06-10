<?php


namespace App\Controller\admin;


use App\Entity\Trick;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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