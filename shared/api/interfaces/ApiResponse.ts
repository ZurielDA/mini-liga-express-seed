export interface ApiResponse {
  status:number;
  message:string;
  data?:object | Array<any>[];
  error?:string;
}
