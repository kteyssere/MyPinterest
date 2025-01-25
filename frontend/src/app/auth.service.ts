import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  constructor() {}

  // Vérifie si l'utilisateur est connecté
  isLoggedIn(): boolean {
    const sessionValue = sessionStorage.getItem('PHPSESSID');
    console.log(sessionValue);
    const cookies = document.cookie.split('; ');
    console.log(cookies);
    console.log(document.cookie);
    console.log(localStorage);
    const token = localStorage.getItem('PHPSESSID');
    console.log(token);
    //return !!token;
    return true;
  }
}
