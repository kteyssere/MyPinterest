import {Component, OnInit} from '@angular/core';
import { PicturesComponent } from '../pictures/pictures.component';
import {MatDivider} from "@angular/material/divider";
import {LoginComponent} from "../login/login.component";
import {UserService} from "../services/user.service";
import {Router} from "@angular/router";
import {MatButton} from "@angular/material/button";
import {MatIcon} from "@angular/material/icon";

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [PicturesComponent, MatDivider, LoginComponent, MatButton, MatIcon],
  templateUrl: './home.component.html',
  styleUrl: './home.component.scss'
})
export class HomeComponent implements OnInit{

  constructor(private userService: UserService,
              private router: Router) {}

  ngOnInit(): void {
  }
  logout(): void {
    const confirmed = window.confirm('Êtes-vous sûr de vouloir vous déconnecter ?');
    if (confirmed) {
      this.userService.logout().subscribe({
        next: () => {
          console.log('Déconnecté avec succès');
          this.router.navigateByUrl('/login').then(() => {
            window.location.reload();
          });
        },
        error: (err) => {
          if (err.status === 404) {
            console.log('Session déjà supprimée ou erreur de déconnexion');
            this.router.navigateByUrl('/login').then(() => {
              window.location.reload();
            });
          } else {
            console.error('Erreur inattendue :', err);
          }
        },
      });
    }
  }
}
