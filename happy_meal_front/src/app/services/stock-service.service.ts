import {HttpClient} from '@angular/common/http';
import {Injectable} from '@angular/core';
import { environment } from '../../environments/environment';
import {Purchase} from '../models/purchse.js';
import {BehaviorSubject, map, Observable} from 'rxjs';
import {Ingredient} from '../models/dish.js';

@Injectable({
  providedIn: 'root',
})
export class StockService {
  private baseUrl = environment.urls.orderBrokerBaseUrl;
  private getIngredientsStockUrl = `${this.baseUrl}/${environment.urls.stock.getIngredients}`;
  private getPurchaseHistoryUrl = `${this.baseUrl}/${environment.urls.stock.getPurchaseHistory}`;

  constructor(private http: HttpClient) {}

  getIngredientStock(): Observable<any> {
    return this.http.get<any>(this.getIngredientsStockUrl).pipe(
      map(response => response['data'].ingredients as Ingredient[]),
    );
  }

  getPurchaseHistory(): Observable<any> {
    return this.http.get<any>(this.getPurchaseHistoryUrl).pipe(
      map(response => response['data'] as Purchase[]),
    );
  }
}
