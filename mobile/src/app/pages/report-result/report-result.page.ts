import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import {
  IonContent,
  IonHeader,
  IonTitle,
  IonToolbar,
  IonItem,
  IonLabel,
  IonList,
  IonListHeader,
  LoadingController,
  IonCol,
  IonGrid,
  IonRow,
} from '@ionic/angular/standalone';

import { ApiService } from 'src/app/services/apiService';
import { ApiResponse, Standing } from '@miniliga/api';
import { ViewWillEnter } from '@ionic/angular';

@Component({
  selector: 'app-report-result',
  templateUrl: './report-result.page.html',
  styleUrls: ['./report-result.page.scss'],
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
    IonContent,
    IonHeader,
    IonItem,
    IonTitle,
    IonToolbar,
    ReactiveFormsModule,
    IonCol,
    IonGrid,
    IonRow,
  ],
})
export class ReportResultPage implements OnInit, ViewWillEnter {
  standings: Standing[] = [];

  constructor(
    private apiServices: ApiService,
    private loadingCtrl: LoadingController
  ) {}

  async ngOnInit(): Promise<void> {}

  async ionViewWillEnter() {
    await this.loadStandings();
  }

  async loadStandings() {
    const loading = await this.loadingCtrl.create({
      message: 'Recuperando clasificación...',
    });

    loading.present();

    this.apiServices
      .getStandings()
      .then(async (value: ApiResponse) => {
        if (value.status == 200) {
          this.standings = value.data as Standing[];
        } else {
          const loadingError = await this.loadingCtrl.create({
            message: 'No se pudo recuperar la clasificación...',
          });

          loadingError.present();
        }
      })
      .finally(() => {
        loading.dismiss();
      });
  }
}
