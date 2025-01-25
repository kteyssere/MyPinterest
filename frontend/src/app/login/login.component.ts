import { Component } from '@angular/core';
import {MatListModule} from '@angular/material/list';
import {CommonModule, NgOptimizedImage} from '@angular/common';
import {
  MatCard,
  MatCardActions,
  MatCardHeader,
  MatCardImage,
  MatCardSubtitle,
  MatCardTitle
} from "@angular/material/card";
import {MatButtonModule} from "@angular/material/button";
import {MatIcon} from "@angular/material/icon";
import {FormBuilder, FormGroup, ReactiveFormsModule, Validators} from "@angular/forms";
import {Router} from "@angular/router";
import {LoginService} from "../services/login.service";

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [MatListModule, CommonModule, MatCard, MatCardHeader, MatCardTitle, MatCardSubtitle, MatCardActions, MatButtonModule, MatIcon, MatCardImage, NgOptimizedImage, ReactiveFormsModule],

  templateUrl: './login.component.html',
  styleUrl: './login.component.scss'
})


export class LoginComponent {

  form:FormGroup;

  constructor(private fb:FormBuilder,
              private loginService: LoginService,
              private router: Router) {

    this.form = this.fb.group({
      username: ['',Validators.required],
      password: ['',Validators.required]
    });
  }

  login() {
    const val = this.form.value;

    if (val.username && val.password) {
      this.loginService.login(val.username, val.password)
        .subscribe(
          () => {
            this.router.navigateByUrl('/home').then(() => {
              window.location.reload();
            });
          }
        );
    }
  }
}
