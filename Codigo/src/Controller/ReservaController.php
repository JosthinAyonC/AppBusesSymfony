<?php

namespace App\Controller;

use App\Entity\Reserva;
use App\Form\ReservaType;
use App\Repository\ReservaRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reserva')]
class ReservaController extends AbstractController
{
    #[Route('/', name: 'app_reserva_index', methods: ['GET'])]
    public function index(ReservaRepository $reservaRepository): Response
    {
        return $this->render('reserva/index.html.twig');
    }

    #[Route('/get', name: 'app_reserva_api', methods: ['GET'])]
    public function getUsuarios(EntityManagerInterface $entityManager): Response
    {
        $reservas = $entityManager
            ->getRepository(Reserva::class)
            ->buscarReserva();

        return $this->json($reservas);
    }

    #[Route('/new', name: 'app_reserva_new', methods: ['GET', 'POST'])]
    public function indexNuevoReseva(): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('reserva/new.html.twig');
        } else {
            return $this->render('usuario/accesDenied.html.twig');
        }
    }

    #[Route('/nuevo', name: 'app_reserva_nuevo', methods: ['GET', 'POST'])]
    public function new(Request $request, ReservaRepository $reservaRepository): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {

            $jsonString = $request->getContent();
            $data = json_decode($jsonString, true);

            $reservaNew = new Reserva();

            $reservaNew->setNombre($data['nombre']);
            $reservaNew->setPrecio($data['precio']);
            $fecha = DateTime::createFromFormat('Y-m-d H:i', $data['fecha'] . ' ' . $data['hora']);
            $reservaNew->setFecha($fecha);
            $reservaNew->setEstado('Disponible');

            $reservaRepository->save($reservaNew, true);

            return $this->json($reservaNew);
        } else {
            return $this->render('usuario/accesDenied.html.twig');
        }
    }

    #[Route('/editar/{id}', name: 'editar_reserva', methods: ['GET'])]
    public function editarUsuario(string $id, ReservaRepository $reservaRepository): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {

            $reserva = $reservaRepository->findOneByReservaId($id);

            return $this->render('reserva/edit.html.twig', [
                'reserva' => $reserva
            ]);
        } else {
            return $this->render('usuario/accesDenied.html.twig');
        }
    }

    #[Route('/{idReserva}', name: 'app_reserva_show', methods: ['GET'])]
    public function show(Reserva $reserva): Response
    {
        return $this->render('reserva/show.html.twig', [
            'reserva' => $reserva,
        ]);
    }

    #[Route('/{id}/editar', name: 'actualizar_reserva', methods: ['PUT', 'POST'])]
    public function editarReservaPut(
        Request $request,
        string $id,
        ReservaRepository $reservaRepository
    ): Response {

        if ($this->isGranted('ROLE_ADMIN')) {
            
            $reserva = $reservaRepository->findOneByReservaId($id);

            $jsonString = $request->getContent();
            $data = json_decode($jsonString, true);

            $reserva->setNombre($data['nombre']);
            $reserva->setPrecio($data['precio']);
            $fecha = DateTime::createFromFormat('Y-m-d H:i', $data['fecha'] . ' ' . $data['hora']);
            $reserva->setFecha($fecha);
            $reserva->setEstado($data['estado']);

            $reservaRepository->save($reserva, true);


            return $this->json($reserva);
        } else {
            return $this->render('usuario/accesDenied.html.twig');
        }
    }

    #[Route('/{idReserva}', name: 'app_reserva_delete', methods: ['POST'])]
    public function delete(Request $request, Reserva $reserva, ReservaRepository $reservaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reserva->getIdReserva(), $request->request->get('_token'))) {
            $reservaRepository->remove($reserva, true);
        }

        return $this->redirectToRoute('app_reserva_index', [], Response::HTTP_SEE_OTHER);
    }
}
