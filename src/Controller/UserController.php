<?php 


// src/Controller/UserController.php
namespace App\Controller;

use App\Entity\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{   
    /**
     * @Route("/users", name="add_user", methods={"POST"})
     */
    public function createAction(Request $request, ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $rd=$request->getContent();
        $data = $serializer->deserialize($rd, 'App\Entity\User', 'json');
        $data->setCreatedDate(new \DateTime());
        $data->setUpdatedDate(new \DateTime());
        $errors = $validator->validate($data);

        if (count($errors)) {
            $errorsString = (string) $errors;
            return new Response($errorsString, Response::HTTP_BAD_REQUEST);
        }
       
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        $response = new Response('', Response::HTTP_CREATED);
        $response->setContent(json_encode(array(
            'message' => 'User created successfully',
            'code' => Response::HTTP_CREATED,
        )));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


     /**
     * @Route("/users", name="show_users", methods={"GET"})
     */
    public function listAction(Request $request, SerializerInterface $serializer)
    {
        $users = $this->getDoctrine()->getRepository('App:User')->findAll();
        $data = $serializer->serialize($users, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     * @Route("/users/{id}", name="update_user", methods={"PUT"})
     */
    public function updateAction($id, ValidatorInterface $validator, Request $request, SerializerInterface $serializer)
    {
        $user = $this->getDoctrine()->getRepository('App:User')->findBy(['id'=>$id]);
        
        //$user = $serializer->serialize($user, 'json');
        $data = $serializer->deserialize($request->getContent(), 'App\Entity\User', 'json');
        //$user = $serializer->deserialize($user, 'App\Entity\User', 'json');

        //$user->setLastname("t");
        $user[0]->setFirstname($data->getFirstname());
        $user[0]->setLastname($data->getLastname());
        $user[0]->setUpdatedDate(new \DateTime());


        $errors = $validator->validate($user);
        if (count($errors)) {
            $errorsString = (string) $errors;
            return new Response($errorsString, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($user[0]);
        $em->flush();

        $response = new Response();
        $response->setContent(json_encode(array(
            'message' => 'User Updated successfully',
            'code' => Response::HTTP_OK,
        )));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     * @Route("/users/{id}", name="find_user", methods={"GET"})
    */
    public function findAction($id, Request $request, SerializerInterface $serializer)
    {
        $users = $this->getDoctrine()->getRepository('App:User')->findBy(['id'=>$id]);
        $data = $serializer->serialize($users, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     * @Route("/users/{id}", name="delete_user", methods={"DELETE"})
    */
    public function removeAction($id, Request $request, SerializerInterface $serializer)
    {
        $users = $this->getDoctrine()->getRepository('App:User')->findBy(['id'=>$id]);
        $data = $serializer->serialize($users, 'json');

        $em = $this->getDoctrine()->getManager();
        $em->remove($users[0]);
        $em->flush();

       
        $response = new Response();
        $response->setContent(json_encode(array(
            'message' => 'User Removed successfully',
            'code' => Response::HTTP_NO_CONTENT,
        )));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}