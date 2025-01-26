import {Component, OnInit} from '@angular/core';
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
import {Router, RouterLink} from "@angular/router";
import {User, UserService} from "../services/user.service";
import {MatError, MatFormField, MatLabel} from "@angular/material/form-field";
import {MatInput} from "@angular/material/input";
import {MatProgressSpinner} from "@angular/material/progress-spinner";

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [MatListModule, CommonModule, MatCard, MatCardHeader, MatCardTitle, MatCardSubtitle, MatCardActions, MatButtonModule, MatIcon, MatCardImage, NgOptimizedImage, ReactiveFormsModule, RouterLink, MatError, MatFormField, MatInput, MatLabel, MatProgressSpinner],

  templateUrl: './login.component.html',
  styleUrl: './login.component.scss'
})


export class LoginComponent implements OnInit {

  loginForm:FormGroup;
  errorMessage: string | null = null;
  isLoading: boolean = false;
  constructor(private fb:FormBuilder,
              private userService: UserService,
              private router: Router) {

    this.loginForm = this.fb.group({
      username: ['',Validators.required],
      password: ['',Validators.required]
    });
  }

  ngOnInit(): void {
    this.loginForm = this.fb.group({
      username: ['', ],
      password: ['', ]
    });

  }

  onSubmit() {
    this.isLoading = true;
    if (this.loginForm.valid) {
      const loggedUser: User = this.loginForm.value;
      this.userService.login(loggedUser)
        .subscribe({
            next: (response) => {
              this.isLoading = false;
              this.router.navigateByUrl('/home');
            },
            error: (error) => {
              this.isLoading = false;
              if(error.status == 401){
                this.errorMessage = 'Invalid username or password.';
              }else {
                this.errorMessage = 'An unexpected error occurred. Please try again later.';
                console.error('Error while login', error);
              }
            }
          }
        );
    }else {
      this.isLoading = false;
      this.errorMessage = 'Please fill out the form correctly before submitting.';
      console.log('Invalid form');
    }
  }
}
