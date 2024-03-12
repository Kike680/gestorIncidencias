<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\RegistroType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\String\Slugger\SluggerInterface;

class UsuarioController extends AbstractController
{
     //Controlar Login Usuario(Admin)
     #[Route('/', name: 'app_login')]
     public function login(AuthenticationUtils $authenticationUtils): Response
     {
         // Obtén el error de login si existe
         $error = $authenticationUtils->getLastAuthenticationError();
         // Último nombre de usuario ingresado por el usuario
         $lastUsername = $authenticationUtils->getLastUsername();
 
         return $this->render('usuario/login.html.twig', [
             'last_username' => $lastUsername,
             'error'         => $error,
         ]);
     }

    //Controlar Registro(Admin)
    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $usuario = new Usuario();
        $form = $this->createForm(RegistroType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('foto')->getData();
            $usuario->setPassword(
                $passwordHasher->hashPassword(
                    $usuario,
                    $form->get('password')->getData()
                )
            );
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('imagenes'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('error, has tenido errores con tu imagen');
                }
                $usuario->setFoto($newFilename);
            }

            $entityManager->persist($usuario);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('usuario/registro.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
   
}
