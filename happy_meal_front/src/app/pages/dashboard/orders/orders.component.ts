import {Component, OnInit} from '@angular/core';
import {Order} from '../../../models/order.js';
import {OrderService} from '../../../services/order-service.service.js';
import {CommonModule} from '@angular/common';
import {map, Observable} from 'rxjs';

@Component({
  selector: 'app-orders',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './orders.component.html',
  styleUrl: './orders.component.css',
})
export class OrdersComponent implements OnInit {
  orders$: Observable<Order[]> | undefined;

  constructor(private orderService: OrderService) {}

  ngOnInit(): void {
    this.orders$ = this.orderService.getOrders();
  }

  filterOrdersByStatus(status: 'pending' | 'cooking' | 'completed'): Observable<Order[]> {
    return this.orders$!.pipe(
      map(orders => orders.filter(order => order.status === status && order.created_at.toDateString() === new Date().toDateString()))
    )
  }
}
