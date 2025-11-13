package com.juana.reserva.controllers;

import java.util.List;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.juana.reserva.models.Reserva;
import com.juana.reserva.repositories.ReservaRepository;

@RestController
@RequestMapping("/api/reservas")
@CrossOrigin(origins = "*") // le doy permiso para la prueba
public class ReservaController {

    @Autowired
    private ReservaRepository reservaRepository;

     private static final Logger logger = LoggerFactory.getLogger(ReservaController.class);


    // obtener todas las reservas
    @GetMapping
    public List<Reserva> obtenerReservas() {
        return reservaRepository.findAll();
    }

    @PostMapping
    public Reserva crearReserva(@RequestBody Reserva reserva) {
        // Log de lo que recibimos
        logger.info("Datos recibidos: " + reserva.toString());

        // Guardamos en la base de datos
        Reserva reservaGuardada = reservaRepository.save(reserva);

        // Log de la reserva guardada
        logger.info("Reserva guardada con éxito: " + reservaGuardada.toString());

        return reservaGuardada;
    }

}
