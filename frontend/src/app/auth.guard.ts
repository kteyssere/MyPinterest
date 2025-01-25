import {inject, Injectable} from '@angular/core';
import {ActivatedRouteSnapshot, CanActivate, CanActivateFn, Router, RouterStateSnapshot} from '@angular/router';
import { AuthService } from './auth.service';

@Injectable({
  providedIn: 'root',
})
export class AuthGuard {
  constructor(private authService: AuthService, private router: Router) {}


  canActivate(): boolean {
    console.log("hello1");
    if (this.authService.isLoggedIn()) {
      // Si l'utilisateur est connecté, autoriser l'accès à la route
      console.log("hello2");
      this.router.navigate(['/home']);
      return true;
    } else {
      console.log("hello3");
      // Si l'utilisateur n'est pas connecté, rediriger vers la page de login
      this.router.navigate(['/login']);
      return false;
    }
  }
}
export const AuthGuardd: CanActivateFn = (next: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean => {
  return inject(AuthGuard).canActivate();
}
