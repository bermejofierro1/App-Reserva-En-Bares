import { Component, OnInit } from '@angular/core';
import { ReservasService } from 'src/app/servicios/reservas.service';

@Component({
  selector: 'app-hoy',
  templateUrl: './hoy.page.html',
  styleUrls: ['./hoy.page.scss'],
  standalone: false
})
export class HoyPage implements OnInit {

  reservas: any[] = [];
  fechaSeleccionada: string = new Date().toISOString().split('T')[0];

  constructor(private reservasService: ReservasService) { }

  ngOnInit() {
    this.cargarReservasPorFecha();

  }

  cargarReservasPorFecha() {

    this.reservasService.getReservasPorFecha(this.fechaSeleccionada).subscribe(
      (data) => {
        this.reservas = data;
        console.log('Reservas cargadas por fecha: ', this.reservas);
      }, (error) => {
        console.log('Error al cargar las reservas por fecha', error);
      }
    );
  }

  filtrarPorFecha(event: any) {
    this.fechaSeleccionada = event.detail.value.split('T')[0];
    this.cargarReservasPorFecha();

  }

}
