<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Solicitud
 *
 * @ORM\Table(name="solicitud", indexes={@ORM\Index(name="IDX_96D27CC0FCF8192D", columns={"id_usuario"}), @ORM\Index(name="IDX_96D27CC0C610874B", columns={"id_reserva"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\SolicitudRepository")
 */
class Solicitud
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_solicitud", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="solicitud_id_solicitud_seq", allocationSize=1, initialValue=1)
     */
    private $idSolicitud;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observacion", type="string", length=200, nullable=true)
     */
    private $observacion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="estado_solicitud", type="string", length=20, nullable=true)
     */
    private $estadoSolicitud;

    /**
     * @var string|null
     *
     * @ORM\Column(name="estado_db", type="string", length=1, nullable=true)
     */
    private $estadoDb;

    /**
     * @var \App\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id_usuario")
     * })
     */
    private $idUsuario;

    /**
     * @var \App\Entity\Reserva
     *
     * @ORM\ManyToOne(targetEntity="Reserva")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_reserva", referencedColumnName="id_reserva")
     * })
     */
    private $idReserva;

    public function getIdSolicitud(): ?int
    {
        return $this->idSolicitud;
    }

    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    public function setObservacion(?string $observacion): self
    {
        $this->observacion = $observacion;

        return $this;
    }

    public function getEstadoSolicitud(): ?string
    {
        return $this->estadoSolicitud;
    }

    public function setEstadoSolicitud(?string $estadoSolicitud): self
    {
        $this->estadoSolicitud = $estadoSolicitud;

        return $this;
    }

    public function getEstadoDb(): ?string
    {
        return $this->estadoDb;
    }

    public function setEstadoDb(?string $estadoDb): self
    {
        $this->estadoDb = $estadoDb;

        return $this;
    }

    public function getIdUsuario(): ?Usuario
    {
        return $this->idUsuario;
    }

    public function setIdUsuario(?Usuario $idUsuario): self
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    public function getIdReserva(): ?Reserva
    {
        return $this->idReserva;
    }

    public function setIdReserva(?Reserva $idReserva): self
    {
        $this->idReserva = $idReserva;

        return $this;
    }


}
