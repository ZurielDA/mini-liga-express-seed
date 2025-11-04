import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
import { ApiResponse, Standing } from '@miniliga/SharedApi';
import { MessageService } from 'primeng/api';
import { ButtonModule } from 'primeng/button';
import { TableModule } from 'primeng/table';
import { ToastModule } from 'primeng/toast';
import { ApiService } from 'src/app/services/apiService';

@Component({
  selector: 'app-standings',
  imports: [TableModule, ToastModule, ButtonModule, RouterLink],
  templateUrl: './standings.html',
  styleUrl: './standings.scss',
  providers: [MessageService],
})
export class Standings {
  standings: Standing[] = [];

  constructor(private apiServices: ApiService, private messageService: MessageService) {}

  ngOnInit(): void {
    const Standig = this.apiServices.getStandings().then((value: ApiResponse) => {
      if (value.status == 200) {
        this.standings = value.data as Standing[];
        this.messageService.add({
          severity: 'success',
          summary: 'success',
          detail: 'Equipos recuperados con exito',
          life: 3000,
        });
      } else {
        this.messageService.add({
          severity: 'danger',
          summary: 'danger',
          detail: 'Error al recueperar los equipos',
          life: 3000,
        });
      }
    });
  }
}
