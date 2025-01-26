import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Picture {
  id: number;
  filename: string;
  path: string;
  isLike?: IsLike;
}

export interface IsLike {
  like?: boolean;
}

@Injectable({
  providedIn: 'root'
})

export class PictureService {

  private apiUrl = 'http://localhost:8000/pictures';

  constructor(private http: HttpClient) {}

  getPictures(): Observable<Picture[]> {
    return this.http.get<Picture[]>(this.apiUrl+'-with-reactions', { withCredentials: true });
  }

  reactToPicture(id:number, likeReaction:boolean): Observable<Picture[]> {
    return this.http.put<Picture[]>('http://localhost:8000/react/picture/'+id, {id,likeReaction},{ withCredentials: true });
  }
}
