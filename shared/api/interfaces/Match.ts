import { Team } from "./Team";


export interface Match {
  id:number,
  home_team_id:number,
  away_team_id:number,
  home_score:number,
  away_score:number,
  played_at: string,
  created_at: string,
  updated_at: string,
  home_team: Team,
  away_team: Team,
}

export interface UpdateResult {
  home_score?: number,
  away_score?: number
}
