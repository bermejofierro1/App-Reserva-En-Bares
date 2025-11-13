import { Component } from '@angular/core';
import { ReservasService } from '../../servicios/reservas.service';
import { Reserva } from '../../interfaces/reserva';
@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
  standalone: false,
})
export class HomePage {
  reservas: any[] = [];

  constructor(private reservasService: ReservasService) {}

  ngOnInit() {
    this.cargarReservas();
  }

  cargarReservas() {
    this.reservasService.getReservas().subscribe(
      (data) => {
        // Aquí deberías verificar que cada reserva tiene el campo 'confirmada'
        this.reservas = data;
        console.log('Reservas cargadas:', this.reservas); // Agrega este log para verificar
      },
      (error) => {
        console.error('Error al cargar las reservas', error);
      }
    );
  }
  
  

 // En el Frontend, modifica los valores como sea necesario
 actualizarEstadoReserva(id: number, confirmada: string) {
  console.log('Actualizando reserva:', id, confirmada);  // Agrega esta línea para verificar
  this.reservasService.actualizarReserva(id, confirmada).subscribe(
    () => {
      console.log('Reserva actualizada con éxito');
      this.cargarReservas();  // Recargar las reservas después de la actualización
    },
    (error) => {
      console.error('Error al actualizar la reserva', error);
    }
  );
}

}
