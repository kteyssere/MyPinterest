import {Component, OnInit} from '@angular/core';
import {MatListModule} from '@angular/material/list';
import { PictureService, Picture } from '../services/picture.service';
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

import {SharedService} from "../services/shared.service";
import {MatIcon} from "@angular/material/icon";
import {Router} from "@angular/router";
import {MatProgressSpinner} from "@angular/material/progress-spinner";

@Component({
  selector: 'app-pictures',
  standalone: true,
  imports: [MatListModule, CommonModule, MatCard, MatCardHeader, MatCardTitle, MatCardSubtitle, MatCardActions, MatButtonModule, MatIcon, MatCardImage, NgOptimizedImage, MatProgressSpinner],

  templateUrl: './pictures.component.html',
  styleUrl: './pictures.component.scss'
})

export class PicturesComponent implements OnInit{
  pictures: Picture[] = [];
  isLoading: boolean = false;

  constructor(private pictureService: PictureService, private sharedService: SharedService, private router: Router) {

  }

  ngOnInit(): void {
    this.pictureService.getPictures().subscribe({
      next: (data) => {this.pictures = data;},
      error: (error) => {

        if(error.status == 401){
          this.router.navigateByUrl('/login').then(() => {
            window.location.reload();
          });
        }else{
          console.error('Error while getting pictures:', error);
        }
      }
    });
  }

  reactToPicture(id:number, likeReaction:boolean){
    this.isLoading = true;
    this.pictureService.reactToPicture(id, likeReaction).subscribe({
        next: (data) => {
          this.isLoading = false;
          this.ngOnInit();
          },
        error: (error) => {
            console.error('Error while reacting to picture:', error);
        }
      }
    );
  }
}
