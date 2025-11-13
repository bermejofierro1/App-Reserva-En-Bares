package com.juana.reserva.models;


import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;

@Entity
public class Reserva {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long idreserva;

    private String nombre;
    private String telefono;
    private String correo;
    private String fecha;

   @Column(name = "num_comensales")
    private int numComensales;


    
    public Reserva() {
    }
    public Reserva(Long id) {
        this.idreserva = id;
    }
    public Long getId() {
        return idreserva;
    }
    public void setId(Long id) {
        this.idreserva = id;
    }
    public String getNombre() {
        return nombre;
    }
    public void setNombre(String nombre) {
        this.nombre = nombre;
    }
    public String getTelefono() {
        return telefono;
    }
    public void setTelefono(String telefono) {
        this.telefono = telefono;
    }
    public String getCorreo() {
        return correo;
    }
    public void setCorreo(String correo) {
        this.correo = correo;
    }
    public String getFecha() {
        return fecha;
    }
    public void setFecha(String fecha) {
        this.fecha = fecha;
    }
    public int getNumComensales() {
        return numComensales;
    }
    public void setNumComensales(int numComensales) {
        this.numComensales = numComensales;
    }

    
}
