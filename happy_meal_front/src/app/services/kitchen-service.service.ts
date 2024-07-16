import {HttpClient} from '@angular/common/http';
import {Injectable} from '@angular/core';
import {environment} from '../../environments/environment';
import {Dish} from '../models/dish.js';
import {BehaviorSubject, map, Observable} from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class KitchenService {
  private baseUrl = environment.urls.orderBrokerBaseUrl;
  private getDishesUrl = `${this.baseUrl}/${environment.urls.dish.getDishes}`;

  constructor (private http: HttpClient) {}

  getDishes(): Observable<any> {
    return this.http.get<any>(this.getDishesUrl).pipe(map(response => response['data'] as Dish[]));
  }
}
