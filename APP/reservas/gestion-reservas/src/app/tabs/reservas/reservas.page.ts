
import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { ReservasService } from 'src/app/servicios/reservas.service';

@Component({
  selector: 'app-reservas',
  templateUrl: './reservas.page.html',
  styleUrls: ['./reservas.page.scss'],
  standalone: false
})
export class ReservasPage implements OnInit {

  reservas: any[] = [];

  constructor(private reservasService: ReservasService,
    private changeDetectorRef: ChangeDetectorRef
  ) { }

  ngOnInit() {
    this.obtenerReservasPendientes();
  }

  obtenerReservasPendientes() {
    this.reservasService.getReservasPendientes().subscribe(
      (data) => {
        this.reservas = data;
        this.changeDetectorRef.detectChanges();
      },
      (error) => {
        console.error('Error al obtener reservas:', error);
      }
    );
  }

  actualizarEstadoReserva(id: number, estado: string) {
    this.reservasService.actualizarReserva(id, estado).subscribe(
      () => {
        console.log(`Reserva ${id} actualizada a ${estado}`);
        this.obtenerReservasPendientes(); // Refrescar la lista
        this.changeDetectorRef.detectChanges();
      },
      (error) => {
        console.error('Error al actualizar la reserva:', error);
      }
    );
  }

}
