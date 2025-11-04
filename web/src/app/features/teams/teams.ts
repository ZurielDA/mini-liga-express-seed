import { Component, inject, OnInit } from '@angular/core';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { ApiResponse, Team, TeamCreate } from '@miniliga/SharedApi';
import { MessageService } from 'primeng/api';
import { DividerModule } from 'primeng/divider';
import { TableModule } from 'primeng/table';
import { ToastModule } from 'primeng/toast';
import { ApiService } from 'src/app/services/apiService';
import { ButtonModule } from 'primeng/button';
import { ConfirmDialogModule } from 'primeng/confirmdialog';
import { InputGroupAddonModule } from 'primeng/inputgroupaddon';
import { InputGroupModule } from 'primeng/inputgroup';
import { InputTextModule } from 'primeng/inputtext';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-teams',
  imports: [
    TableModule,
    ConfirmDialogModule,
    ButtonModule,
    ReactiveFormsModule,
    DividerModule,
    InputGroupModule,
    InputGroupAddonModule,
    InputTextModule,
    ToastModule,
    RouterLink,
  ],
  templateUrl: './teams.html',
  styleUrl: './teams.scss',
  providers: [MessageService],
})
export class Teams implements OnInit {
  private formBuilder = inject(FormBuilder);

  profileForm = this.formBuilder.group({
    name: ['', Validators.required],
  });

  loading: boolean = false;

  teams: Team[] = [];

  constructor(private apiServices: ApiService, private messageService: MessageService) {}

  ngOnInit(): void {
    this.getTeams();
  }

  getTeams(): void {
    this.apiServices.getTeams().then((value: ApiResponse) => {
      if (value.status == 200) {
        this.teams = value.data as Team[];
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

  onSubmit() {
    if (this.profileForm.valid) {
      this.loading = true;

      setTimeout(() => {
        this.apiServices
          .createTeam(this.profileForm.value as TeamCreate)
          .then((value: ApiResponse) => {
            if (value.status == 200) {
              this.teams.unshift(value.data as Team);
              this.messageService.add({
                severity: 'success',
                summary: 'success',
                detail: 'Equipo creado con exito',
                life: 3000,
              });
            }
          })
          .catch((value: ApiResponse) => {
            if (value.status == 409) {
              this.messageService.add({
                severity: 'warn',
                summary: 'warn',
                detail: 'El equipo que se intenta registrar ya existe',
                life: 3000,
              });
            }
          })
          .finally(() => {
            this.loading = false;
          });
      }, 500);
    }
  }
}
