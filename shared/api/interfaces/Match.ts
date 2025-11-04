export interface Match {
  id:number,
  home_team_id:number,
  away_team_id:number,
  home_score:number,
  away_score:number,
  played_at: string,
  created_at: string,
  updated_at: string,
  home_tema: Match,
  away_team: Match,
}

export interface UpdateResult {
  home_score: number,
  away_score: number
}
