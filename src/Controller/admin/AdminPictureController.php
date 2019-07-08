<?php


namespace App\Controller\admin;


use App\Entity\Trick;
use App\Form\EditPictureTrickType;
use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPictureController extends AbstractController
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
     * @Route("/admin/trick/edit/picture/{id}", name="admin.trick.edit.picture", methods="GET|POST")
     *
     * @return Response
     */
    public function editPicture(Trick $trick, Request $request)
    {

        $id = $request->attributes->get('id');
        $form = $this->createForm(EditPictureTrickType::class, $trick, [
            'action' => $this->generateUrl('admin.trick.edit.picture', array('id' => $id)),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            if($form->isValid()){
                $oldpicture = $this->repository->getCurrentPicture($id);
                $dir = $this->getParameter('media_directory');
                $picturefile = $form['picture']->getData();

                if($picturefile){
                    $newFilename = uniqid().'.'.$picturefile->getClientOriginalExtension();

                    try {
                        $picturefile->move(
                            $this->getParameter('media_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    $trick->setPicture($newFilename);

                    $newpicture = $this->getParameter('dir_media').$newFilename;

                    $this->em->flush();

                    if(!is_null($oldpicture['picture'])){
                        unlink($dir.$oldpicture['picture']);
                    }

                    $response = ['newpicture' => $newpicture,
                        'message' => 'success'];

                    return new JsonResponse(json_encode($response));
                }
            }else{
                $errors = array();
                foreach ($form->getErrors(true) as $error) {
                    $errors[] = $error->getMessage();
                };
                $response = ['error' => $errors,
                    'message' => 'error'];

                return new JsonResponse(json_encode($response));

            }
        }

        return $this->render('form/updatepicture.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @param Trick $trick
     * @param Request $request
     *
     * @Route("/admin/trick/delete/picture/{id}", name="admin.trick.delete.picture", methods="GET|DELETE")
     *
     * @return Response
     */
    public function deletePicture(Trick $trick, Request $request)
    {

        if($this->isCsrfTokenValid('delete' . $trick->getId(), $request->get('_token'))){

            $picture = $this->repository->getCurrentPicture($trick->getId());
            $dir = $this->getParameter('media_directory');
            unlink($dir.$picture['picture']);

            $trick->setPicture(null);
            $this->em->flush();

            $response = ['message' => 'success'];

            return new JsonResponse(json_encode($response));

        }

        return $this->render('form/deletepicture.html.twig', [
            'trickid' => $trick->getId(),
        ]);

    }

}