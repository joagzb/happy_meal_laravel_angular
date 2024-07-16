import { Injectable } from '@angular/core';
import {OrderService} from './order-service.service.js';
import {Order} from '../models/order.js';

@Injectable({
  providedIn: 'root'
})
export class WebhookListenerServiceService {

  constructor(private orderService: OrderService) { }

  handleOrderWebhook(order: Order) {
  this.orderService.updateOrderStatus(order.id,order.status);
  }
}
