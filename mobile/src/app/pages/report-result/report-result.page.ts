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
   IonCol, IonGrid, IonRow
} from '@ionic/angular/standalone';

import { ApiService } from 'src/app/services/apiService';
import { ApiResponse, Match, Standing, UpdateResult } from '@miniliga/api';

@Component({
  selector: 'app-report-result',
  templateUrl: './report-result.page.html',
  styleUrls: ['./report-result.page.scss'],
  standalone: true,
  imports: [IonContent,
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
    IonCol, IonGrid, IonRow]
})
export class ReportResultPage implements OnInit {

  standings: Standing[] = [];

  constructor( private apiServices: ApiService, private loadingCtrl: LoadingController) { }

  async ngOnInit():Promise<void>{

    const loading = await this.loadingCtrl.create({
        message: 'Recuperando clasificación...',
      });

      loading.present();

    this.apiServices.getStandings().then(async (value: ApiResponse) => {
      if (value.status == 200) {
        this.standings = value.data as Standing[];

      } else {

        const loadingError = await this.loadingCtrl.create({
          message: 'No se pudo recuperar la clasificación...',
        });

        loadingError.present();

      }
    }).finally(()=>{
        loading.dismiss();
    });
  }
}
