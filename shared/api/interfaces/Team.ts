export interface Team {

  id: number,
  name: string,
  goals_for: number,
  goals_against: number,
  created_at: string,
  updated_at: string,
  played: number,
  home_soport_matches: [],
  away_matches: [],
}

export interface TeamCreate {
  name:string
}
