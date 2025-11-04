import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { ApiService as ApiServiceShared, TeamCreate } from '@miniliga/SharedApi';

@Injectable({
  providedIn: 'root',
})
export class ApiService {

  apiServiceShared = new ApiServiceShared(environment.API_URL);

  constructor() {}

  getTeams = () => this.apiServiceShared.getTeams();

  createTeam = (payload:TeamCreate) => this.apiServiceShared.createTeam(payload);

  getStandings = () => this.apiServiceShared.getStandings();

}
