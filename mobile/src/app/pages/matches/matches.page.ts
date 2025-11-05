import { Component, inject, OnInit, ViewChild } from '@angular/core';
import { CommonModule } from '@angular/common';
import {
  FormBuilder,
  FormsModule,
  ReactiveFormsModule,
  Validators,
} from '@angular/forms';
import {
  IonContent,
  IonHeader,
  IonTitle,
  IonToolbar,
  IonItem,
  IonLabel,
  IonList,
  IonListHeader,
  IonButton,
  IonButtons,
  IonInput,
  IonModal,
  IonIcon,
  IonLoading,
  LoadingController,
} from '@ionic/angular/standalone';

import { ApiService } from 'src/app/services/apiService';
import { ApiResponse, Match, UpdateResult } from '@miniliga/api';

@Component({
  selector: 'app-matches',
  templateUrl: './matches.page.html',
  styleUrls: ['./matches.page.scss'],
  standalone: true,
  imports: [
    IonContent,
    IonHeader,
    IonTitle,
    IonToolbar,
    CommonModule,
    FormsModule,
    IonItem,
    IonLabel,
    IonList,
    IonListHeader,
    FormsModule,
    FormsModule,
    IonButton,
    IonButtons,
    IonContent,
    IonHeader,
    IonInput,
    IonItem,
    IonModal,
    IonTitle,
    IonToolbar,
    IonIcon,
    ReactiveFormsModule,
    IonLoading,
  ],
})
export class MatchesPage implements OnInit {
  private formBuilder = inject(FormBuilder);

  updateResultForm = this.formBuilder.group({
    home_score: [null, [Validators.required, Validators.min(0)]],
    away_score: [null, [Validators.required, Validators.min(0)]],
  });

  matches: Match[] = [];

  constructor(
    private apiServices: ApiService,
    private loadingCtrl: LoadingController
  ) {}

  ngOnInit() {
    this.loadMatchesPending(true);
  }

  async loadMatchesPending(loadinMatches: boolean = false) {
    let loading = null;

    if (loadinMatches) {
      loading = await this.loadingCtrl.create({
        message: 'Obteniendo partidos...',
      });
      loading.present();
    }

    this.apiServices
      .getMatchesPendig()
      .then((value: ApiResponse) => {
        if (value.status == 200) {
          this.matches = value.data as Match[];
        }
      })
      .finally(() => {
        if (loading) {
          loading.dismiss();
        }
      });
  }

  selectedMatch: Match | undefined;

  openModal(match: any) {
    this.selectedMatch = match;
    const modal = document.getElementById('match-modal') as HTMLIonModalElement;
    modal.present();
  }

  cancel() {
    this.updateResultForm.reset();
    const modal = document.getElementById('match-modal') as HTMLIonModalElement;
    modal.dismiss();
  }

  async confirm() {
    if (this.updateResultForm.valid) {
      const loading = await this.loadingCtrl.create({
        message: 'Guardando resultado...',
      });

      loading.present();

      setTimeout(() => {
        this.apiServices
          .updateResult(
            this.selectedMatch!.id,
            this.updateResultForm.value as UpdateResult
          )
          .then((value: ApiResponse) => {
            if (value.status == 200) {
            }
          })
          .catch(async (value: ApiResponse) => {
            if (value.status == 409) {
              const loading = await this.loadingCtrl.create({
                message: `Error: ${value.message}`,
                duration: 3000,
              });
              loading.present();
            }
          })
          .finally(() => {
            this.loadMatchesPending();

            const modal = document.getElementById(
              'match-modal'
            ) as HTMLIonModalElement;
            modal.dismiss();

            loading.dismiss();
          });
      }, 500);
    }
  }

  onWillDismiss(event: any) {
    this.cancel();
  }
}
