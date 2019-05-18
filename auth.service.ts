import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Router } from '@angular/router';
import { map } from 'rxjs/operators'

import * as jwt_decode from 'jwt-decode';

// export const TOKEN_NAME: string = 'jwt_token';
interface loginData{
  success: boolean,
  message: string,
  jwt: any
}
interface jwtData{
  message: string,
  status: string,
  data: string
  
}
@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private loggedInStatus = false

  private headers = new Headers({ 'Content-Type': 'application/json' });

  constructor(private http: HttpClient, private router: Router) { }
  
  setLoggedIn(value: boolean){
    this.loggedInStatus = value;
  }

  isloggedIn(){
   // return this.loggedInStatus
   return !!localStorage.getItem('token')
  }

  getToken(){
    return localStorage.getItem('token')
  }

  getTokenExpirationDate(token: string): Date {
    const decoded = jwt_decode(token);

      if (decoded.exp === undefined) return null;

      const date = new Date(0); 
      date.setUTCSeconds(decoded.exp);
      return date;
      }

    isTokenExpired(token?: string): boolean {
      if(!token) token = this.getToken();
      if(!token) return true;

      const date = this.getTokenExpirationDate(token);
      if(date === undefined) return false;
      return !(date.valueOf() > new Date().valueOf());
    }

  API_SERVER = 'http://localhost:80';

  logIn(credentials) {
    
    // var reqHeader = new HttpHeaders({ 'Content-Type': 'application/x-www-urlencoded','No-Auth':'True' });
    return this.http.post<any>(`${this.API_SERVER}/api/auth`, JSON.stringify(credentials))
    .pipe(map(response => {
    //  console.log(response);
      if ((response.success === true) && response.jwt) {
        localStorage.setItem('token', response.jwt);
        return true;
      }
      return false;
    }));
  }


  logOut(){
    localStorage.removeItem('token');
    this.router.navigate(['/']);
  }

}
