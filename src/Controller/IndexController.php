<?php
namespace App\Controller;

use App\Entity\Departement;
use App\Entity\Employee;

use App\Form\DepartementType;
use App\Form\EmployeeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Routing\Annotation\Route ;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class IndexController extends AbstractController
{

    #[Route('/home',name:'users')]

  public function home()
  {

    $employees= $this->getDoctrine()->getRepository(Employee::class)->findAll();
    return  $this->render('employees/index.html.twig',['employees' => $employees]);  
  }




    /**
     * @Route("/employee/new", name="new_employee")
     * Method({"GET", "POST"})*/ 
    public function newEmployee(Request $request) {
      $employee = new Employee();
      $form = $this->createForm(EmployeeType::class,$employee);
  
        $form = $this->createFormBuilder($employee)
          ->add('nom', TextType::class)
          ->add('salaire', TextType::class)
          ->add('email', TextType::class)
          ->add('bornat', DateType::class)
          ->add('departement',EntityType::class,['class' => Departement::class,
          'choice_label' => 'nomd'])
          ->add('save', SubmitType::class, array(
            'label' => 'Creer'         
          ))->getForm();
  
       
          $form->handleRequest($request);
  
          if($form->isSubmitted() && $form->isValid()) {
            $employee = $form->getData();
    
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($employee);
            $entityManager->flush();
    
            return $this->redirectToRoute('users');
          }
          return $this->render('employees/new.html.twig',['form' => $form->createView()]);
      }
  
        

      

      /**
     * @Route("/employee/{id}", name="employee_show")
     */
    public function show($id) {
      $employee = $this->getDoctrine()->getRepository(Employee::class)->find($id);

      return $this->render('employees/show.html.twig', array('employee' => $employee));
    }


  



    /**
     * @Route("/employee/edit/{id}", name="edit_employee")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
      $employee = new Employee();
      $employee = $this->getDoctrine()->getRepository(Employee::class)->find($id);
  
      $form = $this->createFormBuilder($employee)
      ->add('nom', TextType::class)
      ->add('salaire', NumberType::class)
      ->add('email', TextType::class)
      ->add('bornat', DateType::class)
      ->add('departement',EntityType::class,['class' => Departement::class,
      'choice_label' => 'nomd'])
      ->add('save', SubmitType::class, array(
        'label' => 'Creer'         
      ))->getForm();
  
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();
  
          return $this->redirectToRoute('users');
        }
  
        return $this->render('employees/edit.html.twig', ['form' => $form->createView()]);
      }

   /**
     * @Route("/employee/delete/{id}",name="delete_employee")
     */
    public function delete(Request $request, $id): Response
    {
        $c = $this->getDoctrine()
            ->getRepository(Employee::class)
            ->find($id);
        if (!$c) {
            throw $this->createNotFoundException(
                'pas d"employée  avec id = '.$id
            );
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($c);

        $entityManager->flush();
        return $this->redirectToRoute('users');
    }








    #[Route('/home1',name:'departement_list')]

    public function home1()
    {
  
      $departements= $this->getDoctrine()->getRepository(Departement::class)->findAll();
      return  $this->render('departements/index.html.twig',['departements' => $departements]);  
    }


      
    /**
     * @Route("/departement/new", name="new_departement")
     * Method({"GET", "POST"})
     */
    public function newDepartement(Request $request) {
      $departement = new Departement();
    
      $form = $this->createForm(DepartementType::class,$departement);

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {
        $departement = $form->getData();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($departement);
        $entityManager->flush();
        return $this->redirectToRoute('departement_list');
      }
      return $this->render('departements/new.html.twig',['form' => $form->createView()]);
  }

        /**
     * @Route("/departement/{id}", name="departement_show")
     */
    public function show2($id) {
      $departement = $this->getDoctrine()->getRepository(Departement::class)->find($id);

      return $this->render('departements/show.html.twig', array('departement' => $departement));
    }





 /**
     * @Route("/departement/delete/{id}",name="delete_departement")
     */
    public function delete2(Request $request, $id): Response
    {
        $c = $this->getDoctrine()
            ->getRepository(Departement::class)
            ->find($id);
        if (!$c) {
            throw $this->createNotFoundException(
                'pas de departement  avec id = '.$id
            );
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($c);

        $entityManager->flush();
        return $this->redirectToRoute('departement_list');
    }



}