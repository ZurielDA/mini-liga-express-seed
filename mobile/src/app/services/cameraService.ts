import { Injectable } from '@angular/core';
import { Camera, CameraResultType, CameraSource, Photo } from '@capacitor/camera';

import { ApiService as ApiServiceShared, UpdateResult } from '@miniliga/api';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root',
})

export class CameraService  {

  constructor() {}

  async getPhotoCamera(): Promise<Photo | null> {
    try {
      const image = await Camera.getPhoto({
        quality: 100,
        allowEditing: false,
        resultType: CameraResultType.Uri,
        source: CameraSource.Camera
      });

      return image;
    } catch (error) {
      console.error('Error al tomar foto:', error);
      return null;
    }
  }

  async getPhotoAlbum(): Promise<Photo | null> {
    try {
      const image = await Camera.getPhoto({
        quality: 90,
        allowEditing: false,
        resultType: CameraResultType.Uri,
        source: CameraSource.Photos
      });

      return image;
    } catch (error) {
      console.error('Error al seleccionar foto:', error);
      return null;
    }
  }

  async selectPhotoSource(): Promise<Photo | null> {
    try {
      const image = await Camera.getPhoto({
        quality: 90,
        allowEditing: true,
        resultType: CameraResultType.Uri,
        source: CameraSource.Prompt
      });

      return image;
    } catch (error) {
      console.error('Error al seleccionar imagen:', error);
      return null;
    }
  }
}
