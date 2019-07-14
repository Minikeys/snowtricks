<?php


namespace App\Controller\admin;


use App\Entity\Trick;
use App\Form\EditTrickType;
use App\Form\NewTrickType;
use App\Repository\TrickRepository;
use DateTime;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
     * @param Request $request
     *
     * @return RedirectResponse|Response
     * @throws \Exception
     * @Route("/admin/trick/new/", name="admin.trick.new", methods="GET|POST")
     */
    public function newTrick(Request $request){

        $trick = new Trick();
        $form = $this->createForm(NewTrickType::class, $trick);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $picturefile = $form['picture']->getData();

            if($picturefile) {
                $newFilename = uniqid() . '.' . $picturefile->getClientOriginalExtension();

                try {
                    $picturefile->move(
                        $this->getParameter('media_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $trick->setPicture($newFilename);
            }else{
                $trick->setPicture(null);
            }
            $this->em->persist($trick);
            $trick->setCreatedAt(new DateTime());
            $trick->setPublished('1');
            $trick->setAuthor($this->getUser());
            $this->em->flush();
            $this->addFlash('success', 'Trick ajouté avec succès');
            return $this->redirectToRoute('trick.show', array('slug' => $trick->getId(), 'id' => $trick->getId()));
        }

        return $this->render('admin/trick/new.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @param Trick $trick
     * @param Request $request
     *
     * @return RedirectResponse|Response
     * @throws \Exception
     * @Route("/admin/trick/edit/{id}", name="admin.trick.edit", methods="GET|POST")
     */
    public function editTrick(Trick $trick, Request $request){

        $form = $this->createForm(EditTrickType::class, $trick);
        $form->handleRequest($request);
        $id = $trick->getId();

        if($form->isSubmitted() && $form->isValid()){
            $name = $form['name']->getData();
            $check_duplicate = $this->repository->findTricks($name);

            if($check_duplicate['id'] === $id || empty($check_duplicate)){
                $this->em->persist($trick);
                $trick->setUpdateAt(new DateTime());
                $this->em->flush();
                $this->addFlash('success', 'Trick edité avec succès');
                return $this->redirectToRoute('trick.show', array('slug' => $trick->getId(), 'id' => $trick->getId()));
            }else{
                $this->addFlash('error', 'Nom déjà utilisé');
                return $this->redirectToRoute('admin.trick.edit', array('id' => $trick->getId()));
            }
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
    public function deleteTrick(Trick $trick, Request $request){

        if($this->isCsrfTokenValid('delete' . $trick->getId(), $request->get('_token'))){

            $this->em->remove($trick);
            $this->em->flush();
            $this->addFlash('success', 'Trick delete success');

        }else{

            $this->addFlash('error', 'Trick delete error');

        }

        return $this->redirectToRoute('home');

    }

}