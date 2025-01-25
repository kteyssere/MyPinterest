import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface User {
 // id: number;
  username: string;
  password: string;
}

@Injectable({
  providedIn: 'root'
})

export class LoginService {

  private apiUrl = 'http://localhost:8000/login';

  constructor(private http: HttpClient) {}

  login(username: string, password: string): Observable<any> {
    return this.http.post<any>(
      this.apiUrl,
      { username, password },
      { withCredentials: true }
    );
  }

  logout(): Observable<any> {
    return this.http.post<any>(
      'http://localhost:8000/logout',
      {},
      { withCredentials: true }
    );
  }
}
