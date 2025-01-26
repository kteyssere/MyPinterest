import {Component, OnInit} from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { UserService, User } from '../services/user.service';
import { ReactiveFormsModule } from '@angular/forms';
import {MatError, MatFormField, MatFormFieldModule, MatHint} from "@angular/material/form-field";
import {MatInput, MatInputModule} from "@angular/material/input";
import {MatDatepicker, MatDatepickerInput, MatDatepickerModule} from "@angular/material/datepicker";
import {MatButton, MatButtonModule} from "@angular/material/button";
import {MatLabel} from "@angular/material/form-field";
import { CommonModule } from '@angular/common';
import {MatNativeDateModule} from "@angular/material/core";
import {MatIcon} from "@angular/material/icon";
import {HttpClientModule} from "@angular/common/http";
import {Router, RouterLink} from "@angular/router";
import {SharedService} from "../services/shared.service";

@Component({
  selector: 'app-register',
  standalone: true,
  imports: [ReactiveFormsModule, MatFormFieldModule, MatInputModule, MatError, MatDatepickerInput,
    MatDatepickerModule, MatButtonModule, MatLabel, CommonModule, MatDatepickerModule, MatNativeDateModule, MatIcon, MatHint,
    HttpClientModule, RouterLink],
  templateUrl: './register.component.html',
  styleUrl: './register.component.scss'
})
export class RegisterComponent implements OnInit {
  registerForm: FormGroup;
  errorMessage: string | null = null;
  constructor(private fb: FormBuilder, private userService: UserService, private router: Router, private sharedService: SharedService) {
    this.registerForm = this.fb.group({
      username: ['', Validators.required],
      password: ['', Validators.required]
    });
  }

  ngOnInit(): void {
    this.registerForm = this.fb.group({
      username: ['', ],
      password: ['', ]
    });

  }

  // Soumettre le formulaire
  onSubmit(): void {
    if (this.registerForm.valid) {

      const newUser: User = this.registerForm.value;
      this.userService.register(newUser).subscribe({
        next: (response) => {
         this.router.navigateByUrl('/login');
        },
        error: (error) => {
            this.errorMessage = 'An unexpected error occurred. Please try again later.';
            console.error('Error while registering',error);
        }
      });
    } else {
      this.errorMessage = 'Please fill out the form correctly before submitting.';
      console.log('Invalid form');
    }
  }
}
