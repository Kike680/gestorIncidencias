<?php

namespace App\Controller;

use App\Entity\Incidencias;
use App\Form\IncidenciaType;
use App\Repository\ClienteRepository;
use App\Repository\IncidenciasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IncidenciasController extends AbstractController
{       //Accion que debe hacer dependiendo las rutas


    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }

    #[Route('/incidencias', name: 'app_incidencias')]
    public function index(): Response
    {
        return $this->render('incidencias/index.html.twig', [
            'controller_name' => 'IncidenciasController',
        ]);
    }

    #[Route('/incidencia/{id}/add', name: 'crearIncidencia')]
public function addIncidencia(EntityManagerInterface $entityManager, Request $request, ClienteRepository $clienteRepository, int $id): Response
{
    $this->denyAccessUnlessGranted('ROLE_USER', null, 'Acceso denegado');
    $cliente = $clienteRepository->find($id);

    if (!$cliente) {
        throw $this->createNotFoundException('No se encontró el cliente con id '.$id);
    }

    $incidencia = new Incidencias();
    $incidencia->setCliente($cliente); 

    $formularioIncidencia = $this->createForm(IncidenciaType::class, $incidencia);
    $formularioIncidencia->handleRequest($request);
    
    if ($formularioIncidencia->isSubmitted() && $formularioIncidencia->isValid()) {
        $entityManager->persist($incidencia);
        $entityManager->flush();

        return $this->redirectToRoute('cliente_incidencias', ['id' => $id]);
    }
                //El index es el de Creacion 
    return $this->render('incidencias/index.html.twig', [
        'formularioIncidencia' => $formularioIncidencia->createView(),
    ]);
}
#[Route('/borrarIncidencia/{id}', name: 'borrarIncidencia')]
    public function borrarCliente(Request $request, Incidencias $incidencia): Response
    {
    if ($incidencia) {
        $this->em->remove($incidencia);
        $this->em->flush();
        $idCliente = $incidencia->getCliente()->getId();
        $this->addFlash('success', 'Cliente eliminado con éxito.');
    } else {
        $this->addFlash('error', 'Cliente no encontrado.');
    }

    return $this->redirectToRoute('cliente_incidencias', ['id'=> $idCliente]);
}
#[Route('/editarIncidencia/{id}', name: 'editarIncidencia')]
public function editarIncidencia(Request $request, Incidencias $incidencia): Response
{
    $form = $this->createForm(IncidenciaType::class, $incidencia);
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
        $this->em->flush();
        $idCliente = $incidencia->getCliente()->getId();
        $this->addFlash('success', 'Incidencia actualizada con éxito.');
        return $this->redirectToRoute('cliente_incidencias', ['id'=> $idCliente]);
    }
    
    return $this->render('incidencias/editar.html.twig', [
        'form' => $form->createView(),
    ]);
}
#[Route('/verIncidencias', name: 'mostrarTodasIncidencias')]
public function verIncidencias(IncidenciasRepository $incidenciaRepository): Response
{
    $this->denyAccessUnlessGranted('ROLE_USER', null, 'Acceso denegado');
    // Obtener todas las incidencias del repositorio
    $incidencias = $incidenciaRepository->findAll();
    return $this->render('incidencias/mostrarTodasIncidencias.html.twig', [
        'incidencias' => $incidencias,
    ]);
}

}
