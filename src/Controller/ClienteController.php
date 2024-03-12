<?php

namespace App\Controller;
use App\Repository\ClienteRepository;
use App\Repository\IncidenciasRepository;
use App\Entity\Cliente;
use App\Form\ClienteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClienteController extends AbstractController
{

    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }

    #[Route('/crearCliente', name: 'crearCliente')]
    public function crearCliente(Request $request): Response
    {
        $cliente = new Cliente();
        $form = $this->createForm(ClienteType::class, $cliente);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()){
            $this->addFlash('ss', 'Añadido de forma correcta');
            $this->em->persist($cliente);
            $this->em->flush();
            return $this->redirectToRoute('app_cliente');
        }
        return $this->render('cliente/index.html.twig', [
            'form' => $form->createView()
        ]);

    }
   
  
    #[Route('/mostrarClientes', name: 'app_cliente')]
    public function mostrarClientes(Request $request, ClienteRepository $clienteRepository): Response
    {

        //Verificamos que nuestro usuario tiene el rol de ROL_USER_AUTHENTICATED
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Acceso Prohibido por falta de permisos');

        $cliente = $clienteRepository->findAll();
        return $this->render('cliente/verClientes.html.twig', [
            'clientes'=> $cliente
        ]);
    }
    #[Route('/borrarCliente/{id}', name: 'borrarCliente')]
    public function borrarCliente(Request $request, Cliente $cliente): Response
    {
    if ($cliente) {
        $this->em->remove($cliente);
        $this->em->flush();
        $this->addFlash('success', 'Cliente eliminado con éxito.');
    } else {
        $this->addFlash('error', 'Cliente no encontrado.');
    }

    return $this->redirectToRoute('app_cliente');
}
//Editar cliente luego si eso
#[Route('/editarCliente/{id}', name: 'editarCliente')]
public function editarCliente(Request $request, Cliente $cliente): Response
{
    $form = $this->createForm(ClienteType::class, $cliente);
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
        $this->em->flush();
        $this->addFlash('success', 'Cliente actualizado con éxito.');
        return $this->redirectToRoute('app_cliente');
    }
    
    return $this->render('cliente/editar.html.twig', [
        'form' => $form->createView(),
    ]);
}
#[Route('/cliente/{id}/incidencias', name: 'cliente_incidencias')]
public function mostrarIncidenciasCliente(Cliente $cliente, IncidenciasRepository $incidenciaRepository): Response
{
    $incidencias = $incidenciaRepository->findBy(['cliente' => $cliente->getId()]);

    return $this->render('cliente/incidenciasPorCliente.html.twig', [
        'cliente' => $cliente,
        'incidencias' => $incidencias,
    ]);
}



}
