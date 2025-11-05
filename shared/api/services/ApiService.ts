import { ApiResponse } from "../interfaces/ApiResponse";
import { UpdateResult } from "../interfaces/Match";
import { TeamCreate } from "../interfaces/Team";

export class ApiService {

  constructor(private baseUrl:string){}

  private async request(path:string, options:RequestInit = {}):Promise<ApiResponse>{

    const res = await fetch(`${this.baseUrl}${path}`, options);

      let body: any = null;

      try {
        body = await res.json();
      } catch {
        body = {};
      }

      if (!res.ok) {

        const apiError: ApiResponse = {
          status: res.status,
          data: body,
          message: body?.message || `Error HTTP ${res.status}`,
          error: body?.error,
        };

        throw apiError;
      }

      return {
        status: res.status,
        data: body.data ?? body,
        message: body?.message || 'OK',
      };
  }

  getTeams = async (): Promise<ApiResponse>  => await this.request('/api/teams', { method: 'GET' });

  createTeam = async (Team:TeamCreate): Promise<ApiResponse> => {
    return await this.request('/api/teams', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(Team),
    })
  }

  getStandings = async (): Promise<ApiResponse> => this.request('/api/standings', { method: 'GET' });

  updateMatch = async (id:number, updateResult:UpdateResult): Promise<ApiResponse> => {
      return this.request(`/api/matches/${id}/result`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(updateResult),
      });
  }

  getMatchesPendig= async (): Promise<ApiResponse>  => await this.request('/api/matches/pending', { method: 'GET' });

}
