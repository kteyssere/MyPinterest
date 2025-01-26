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

export class UserService {

  private apiUrl = 'http://localhost:8000/';

  constructor(private http: HttpClient) {}

  login(user: User): Observable<any> {
    return this.http.post<any>(
      this.apiUrl+'login',
      user,
      { withCredentials: true }
    );
  }

  logout(): Observable<any> {
    return this.http.post<any>(
      this.apiUrl+'logout',
      {},
      { withCredentials: true }
    );
  }

  register(user: User): Observable<User> {
    return this.http.post<User>(this.apiUrl+'register', user, { withCredentials: true });
  }
}
