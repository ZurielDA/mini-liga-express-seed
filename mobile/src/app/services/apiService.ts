import { Injectable } from '@angular/core';

import { ApiService as ApiServiceShared, UpdateResult } from '@miniliga/api';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root',
})

export class ApiService {

  apiServiceShared = new ApiServiceShared(environment.API_URL);

  constructor() {}

  getMatchesPendig = () => this.apiServiceShared.getMatchesPendig();

  updateResult = (id:number, updateResult:UpdateResult) => this.apiServiceShared.updateMatch(id, updateResult);
}
