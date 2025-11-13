import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import axios from 'axios';
import { BehaviorSubject, map, Observable, tap } from 'rxjs';
import { Reserva } from '../interfaces/reserva';

@Injectable({
  providedIn: 'root'
})
export class ReservasService {

  private apiUrl = '';  // URL de tu API
  private actualizarReservaUrl = '';  // URL para actualizar reserva
  private reservasSubject = new BehaviorSubject<any[]>([]);
  constructor(private http: HttpClient) { }

  getReservas(): Observable<any> {
    return this.http.get<any>(this.apiUrl).pipe(
      tap((data) => {
        console.log('Datos recibidos:', data);
        data.forEach((reserva: any) => {
          console.log(`Reserva ID: ${reserva.id}, Confirmada: ${reserva.confirmada}`);
        });
      })
    );
  }


  // Método para actualizar el estado de la reserva (aceptada o rechazada)
  actualizarReserva(id: number, confirmada: string): Observable<any> {
    return this.http.put(this.actualizarReservaUrl, { id, confirmada });
  }

  getReservasPendientes(): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}?estado=pendiente`).pipe(
      tap((data) => {
        console.log('Reservas pendientes:', data);
      })
    );
  }



  getTodasLasReservas(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/reservas`); // Cambia la URL según tu API
  }

  getReservasPorFecha(fecha: string): Observable<any> {
    let params = new HttpParams();
    params = params.set('fecha', fecha);

    return this.http.get<any>(`${this.apiUrl}-fecha`, { params }).pipe(
      tap((data) => {
        console.log('Datos recibidos por fecha:', data);
        if (Array.isArray(data)) { // Verificar si data es un array
          data.forEach((reserva: any) => {
            console.log(`Reserva ID: ${reserva.id}, Confirmada: ${reserva.confirmada}`);
          });
        } else {
          console.log('La respuesta no es un array.');
        }
      }),
      map(data => Array.isArray(data) ? data : []) // Asegura que siempre se devuelva un array
    );
  }

}
