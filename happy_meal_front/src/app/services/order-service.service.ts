import {HttpClient} from '@angular/common/http';
import {Injectable} from '@angular/core';
import {BehaviorSubject, Observable} from 'rxjs';
import {Order, OrderStatus} from '../models/order.js';
import { environment } from '../../environments/environment';
@Injectable({
  providedIn: 'root',
})
export class OrderService {
  private baseUrl = environment.urls.orderBrokerBaseUrl;
  private getOrdersUrl = `${this.baseUrl}/${environment.urls.orders.getOrders}`;
  private getOrdersByIdUrl = `${this.baseUrl}/${environment.urls.orders.getOrderById}`;
  private makeOrderUrl = `${this.baseUrl}/${environment.urls.orders.makeOrder}`;

  private orders: Order[] = [];
  private ordersSubject = new BehaviorSubject<Order[]>(this.orders);

  constructor(private http: HttpClient) {
    this.fetchOrdersFromBroker();
  }

  getOrders(): Observable<Order[]> {
    return this.ordersSubject.asObservable();
  }

  appendNewOrder(order: Order) {
    this.orders.push(order);
    this.ordersSubject.next(this.orders);
  }

  private fetchOrdersFromBroker(): void {
    this.http.get<any>(this.getOrdersUrl).subscribe(response => {
      const mappedOrders: Order[] = response['data'].map((item:Order) => ({
        id: item.id,
        dish: {
          name: item.dish.name,
        },
        created_at: new Date(item.created_at),
        status: item.status,
      }));

      this.orders = mappedOrders;
      this.ordersSubject.next(this.orders);
    });
  }

  updateOrderStatus(orderId: number, status: OrderStatus) {
    const order = this.orders.find(o => o.id === orderId);
    if (order) {
      order.status = status;
      this.ordersSubject.next(this.orders);
    }
  }

  makeOrder(): Observable<any> {
    const response = this.http.post<any>(this.makeOrderUrl,{});
    this.fetchOrdersFromBroker();
  }
}
