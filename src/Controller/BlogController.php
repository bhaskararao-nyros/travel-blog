<?php

namespace App\Controller;

use App\Entity\Story;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BlogController extends Controller
{
	/**
	 * @Route("/", name="homepage")
	 * @Method({"GET"})
	 */
    public function index()
    {
    	$stories = $this->getDoctrine()->getRepository(Story::class)->findAll();

        return $this->render('stories/index.html.twig', array('stories' => $stories));
    }

    /**
     * @Route("/new", name="add_story")
     * Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
    	$story = new Story();
    	$form = $this->createFormBuilder($story)
    		->add('title', TextType::class, array('attr' => array('class'=>'form-control')))
    		->add('description', TextareaType::class, array('required' => false, 'attr' => array('class' => 'form-control')))
    		->add('created_by', TextType::class, array('attr' => array('class'=>'form-control')))
    		->add('save', SubmitType::class, array('label'=>'Create', 'attr'=>array('class'=>'btn btn-primary btn-sm mt-3')))
    		->getForm();

    	$form->handleRequest($request);
    	if ($form->isSubmitted() && $form->isValid()) {
    	
	    	$story = $form->getData();

	    	$entityManager = $this->getDoctrine()->getManager();
	    	$entityManager->persist($story);
	    	$entityManager->flush();

	    	return $this->redirectToRoute('homepage');
	    }

    		return $this->render('stories/new.html.twig', array('form' => $form->createView()));

    }

    /**
     * @Route("/edit/{id}", name="edit_story")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id)
    {
    	$story = new Story();
    	$story = $this->getDoctrine()->getRepository(Story::class)->find($id);

    	$form = $this->createFormBuilder($story)
    		->add('title', TextType::class, array('attr' => array('class'=>'form-control')))
    		->add('description', TextareaType::class, array('required' => false, 'attr' => array('class' => 'form-control')))
    		->add('created_by', TextType::class, array('attr' => array('class'=>'form-control')))
    		->add('save', SubmitType::class, array('label'=>'Update', 'attr'=>array('class'=>'btn btn-secondary btn-sm mt-3')))
    		->getForm();

    	$form->handleRequest($request);
    	if ($form->isSubmitted() && $form->isValid()) {
    	
	    	$entityManager = $this->getDoctrine()->getManager();
	    	$entityManager->flush();

	    	return $this->redirectToRoute('homepage');
	    }

    		return $this->render('stories/edit.html.twig', array('form' => $form->createView()));

    }

    /**
     * @Route("/show/{id}")
     */
    public function show($id)
    {
    	$story = $this->getDoctrine()->getRepository(Story::class)->find($id);

    	return $this->render('stories/show.html.twig', array('story' => $story));
    }

    /**
     * @Route("/delete/{id}")
     */
    public function delete($id)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$story = $this->getDoctrine()->getRepository(Story::class)->find($id);

    	$em->remove($story);
    	$em->flush();

    	return $this->redirectToRoute('homepage');
	}
}