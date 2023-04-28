<?php

namespace App\Controller;

use App\Entity\Solicitud;
use App\Form\SolicitudType;
use App\Repository\SolicitudRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/solicitud')]
class SolicitudController extends AbstractController
{
    #[Route('/', name: 'app_solicitud_index', methods: ['GET'])]
    public function index(SolicitudRepository $solicitudRepository): Response
    {
        if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_SECRETARIA')){
            
            return $this->render('solicitud/index.html.twig', [
                'solicituds' => $solicitudRepository->findAll(),
            ]);
        } else if($this->isGranted('ROLE_CLIENTE') ) {
            return $this->render('solicitud/indexCliente.html.twig', [
                'solicituds' => $solicitudRepository->findAll(),
            ]);
        
        }else{
            return $this->render('usuario/accesDenied.html.html.twig');
        }
    }

    #[Route('/new', name: 'app_solicitud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SolicitudRepository $solicitudRepository): Response
    {
        $solicitud = new Solicitud();
        $form = $this->createForm(SolicitudType::class, $solicitud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $solicitud->setEstadoSolicitud("Pendiente");
            $solicitudRepository->save($solicitud, true);

            return $this->redirectToRoute('app_solicitud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('solicitud/new.html.twig', [
            'solicitud' => $solicitud,
            'form' => $form,
        ]);
    }

    #[Route('/{idSolicitud}', name: 'app_solicitud_show', methods: ['GET'])]
    public function show(Solicitud $solicitud): Response
    {
        return $this->render('solicitud/show.html.twig', [
            'solicitud' => $solicitud,
        ]);
    }

    #[Route('/{idSolicitud}/edit', name: 'app_solicitud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Solicitud $solicitud, SolicitudRepository $solicitudRepository): Response
    {
        $form = $this->createForm(SolicitudType::class, $solicitud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $solicitudRepository->save($solicitud, true);

            return $this->redirectToRoute('app_solicitud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('solicitud/edit.html.twig', [
            'solicitud' => $solicitud,
            'form' => $form,
        ]);
    }

    #[Route('/{idSolicitud}', name: 'app_solicitud_delete', methods: ['POST'])]
    public function delete(Request $request, Solicitud $solicitud, SolicitudRepository $solicitudRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$solicitud->getIdSolicitud(), $request->request->get('_token'))) {
            $solicitudRepository->remove($solicitud, true);
        }

        return $this->redirectToRoute('app_solicitud_index', [], Response::HTTP_SEE_OTHER);
    }
}
