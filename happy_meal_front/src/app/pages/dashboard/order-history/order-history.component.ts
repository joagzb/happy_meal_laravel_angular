import {Component, OnDestroy, OnInit} from '@angular/core';
import {Order} from '../../../models/order.js';
import {OrderService} from '../../../services/order-service.service.js';
import {map, Observable, Subscription} from 'rxjs';
import {CommonModule} from '@angular/common';

@Component({
  selector: 'app-order-history',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './order-history.component.html',
  styleUrl: './order-history.component.css',
})
export class OrderHistoryComponent implements OnInit, OnDestroy {
  private subscription: Subscription = new Subscription();
  orders$: Observable<Order[]> | undefined;
  paginatedOrders: Order[] = [];
  currentPage = 1;
  itemsPerPage = 10;
  totalPages = 0;
  sortOrder: 'asc' | 'desc' = 'asc';
  sortField: 'id' | 'dish.name' | 'created_at' = 'created_at';

  constructor(private orderService: OrderService) {}

  ngOnInit() {
    this.orders$ = this.orderService.getOrders();

    const ordersSubscription = this.orders$.subscribe(orders => {
      this._setTotalPages(orders);
      this._paginateItems(orders);
    });

    this.subscription.add(ordersSubscription);
  }

  ngOnDestroy() {
    this.subscription.unsubscribe();
  }

  private _setTotalPages(orders: Order[]) {
    this.totalPages = Math.ceil(orders.length / this.itemsPerPage);
  }

  private _paginateItems(orders: Order[]) {
    this.paginatedOrders = orders.sort((a, b) => this._comparator(a, b)).slice((this.currentPage - 1) * this.itemsPerPage, this.currentPage * this.itemsPerPage);
  }

  private _comparator(a: Order, b: Order): number {
    const fieldA = this.sortField === 'dish.name' ? a.dish.name : a[this.sortField];
    const fieldB = this.sortField === 'dish.name' ? b.dish.name : b[this.sortField];

    if (fieldA < fieldB) return this.sortOrder === 'asc' ? -1 : 1;
    if (fieldA > fieldB) return this.sortOrder === 'asc' ? 1 : -1;
    return 0;
  }

  sort(field: 'id' | 'dish.name' | 'created_at') {
    this.sortField = field;
    this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
    this.updatePagination();
  }

  nextPage() {
    if (this.currentPage < this.totalPages) {
      this.currentPage++;
      this.updatePagination();
    }
  }

  previousPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
      this.updatePagination();
    }
  }

  updatePagination() {
    if (this.orders$) {
      this.orders$.subscribe(orders => {
        this._paginateItems(orders);
      });
    }
  }

  printSortOrderIcon() {
    return this.sortOrder === 'asc' ? ' ▲' : ' ▼';
  }
}
